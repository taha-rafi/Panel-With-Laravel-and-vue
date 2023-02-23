<?php

namespace App\SuperAdmin\Http\Controllers\Front;

use App\Models\Company;
use App\SuperAdmin\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Scopes\CompanyScope;
use App\SuperAdmin\Models\PaymentTranscation;
use App\SuperAdmin\Traits\StripeSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stripe\Stripe;
use Stripe\Webhook;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class PaymentWebhookController extends Controller
{
    use StripeSettings;

    public function saveStripeInvoices(Request $request)
    {
        $this->setStripConfigs();
        $stripeCredentials = config('cashier.webhook.secret');

        Stripe::setApiKey(config('cashier.secret'));

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = $stripeCredentials;

        $payload = @file_get_contents("php://input");
        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
        $event = null;

        try {

            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid Payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('Invalid signature', 400);
        }

        $payload = json_decode($request->getContent(), true);

        // Do something with $event
        if ($payload['type'] == 'invoice.payment_succeeded') {
            $planId = $payload['data']['object']['lines']['data'][0]['plan']['id'];
            $customerId = $payload['data']['object']['customer'];
            $amount = $payload['data']['object']['amount_paid'];
            $transactionId = $payload['data']['object']['lines']['data'][0]['id'];
            //            $invoiceId = $payload['data']['object']['number'];
            $invoiceRealId = $payload['data']['object']['id'];

            $company = Company::where('stripe_id', $customerId)->first();

            $package = SubscriptionPlan::where(function ($query) use ($planId) {
                $query->where('stripe_annual_plan_id', '=', $planId)
                    ->orWhere('stripe_monthly_plan_id', '=', $planId);
            })->first();

            if ($company) {
                // Store invoice details
                $stripeInvoice = new PaymentTranscation();
                $stripeInvoice->payment_method = 'stripe';
                $stripeInvoice->company_id = $company->id;
                $stripeInvoice->invoice_id = $invoiceRealId;
                $stripeInvoice->transcation_id = $transactionId;
                $stripeInvoice->total = $amount / 100;
                $stripeInvoice->subscription_plan_id = $package->id;
                $stripeInvoice->paid_on = \Carbon\Carbon::now()->format('Y-m-d');
                $stripeInvoice->next_payment_date = \Carbon\Carbon::createFromTimeStamp($company->upcomingInvoice()->next_payment_attempt)->format('Y-m-d');

                $stripeInvoice->save();

                // Change company status active after payment
                $company->status = 'active';
                $company->save();

                // $generatedBy = User::whereNull('company_id')->get();
                // $lastInvoice = StripeInvoice::where('company_id')->first();

                // TODO - Notifications
                //                if($lastInvoice){
                //                    Notification::send($generatedBy, new CompanyUpdatedPlan($company, $package->id));
                //                }else{
                //                    Notification::send($generatedBy, new CompanyPurchasedPlan($company, $package->id));
                //                }

                return response('Webhook Handled', 200);
            }

            return response('Customer not found', 200);
        } elseif ($payload['type'] == 'invoice.payment_failed') {
            $customerId = $payload['data']['object']['customer'];

            $company = Company::where('stripe_id', $customerId)->first();
            $subscription = Subscription::where('payment_method', 'stripe')->where('company_id', $company->id)->first();

            if ($subscription) {
                $subscription->ends_at = \Carbon\Carbon::createFromTimeStamp($payload['data']['object']['current_period_end'])->format('Y-m-d');
                $subscription->save();
            }

            if ($company) {

                $company->licence_expire_on = \Carbon\Carbon::createFromTimeStamp($payload['data']['object']['current_period_end'])->format('Y-m-d');
                $company->save();

                return response('Company subscription canceled', 200);
            }

            return response('Customer not found', 200);
        }
    }

    public function verifyBillingIPN(Request $request)
    {
        $txnType = $request->get('txn_type');
        if ($txnType == 'recurring_payment') {

            $recurringPaymentId = $request->get('recurring_payment_id');
            $eventId = $request->get('ipn_track_id');

            $event = PaymentTranscation::online()->withoutGlobalScope(CompanyScope::class)->paypal()->where('invoice_id', $eventId)->count();

            if ($event == 0) {
                $payment =  PaymentTranscation::online()->withoutGlobalScope(CompanyScope::class)->paypal()->where('transcation_id', $recurringPaymentId)->first();

                $today = Carbon::now();
                $company = Company::findOrFail($payment->company_id);
                if ($company->package_type == 'annual') {
                    $nextPaymentDate = $today->addYear();
                } else if ($company->package_type == 'monthly') {
                    $nextPaymentDate = $today->addMonth();
                }

                $paypalInvoice = new PaymentTranscation();
                $paypalInvoice->payment_method = 'paypal';
                $paypalInvoice->transcation_id = $recurringPaymentId;
                $paypalInvoice->company_id = $payment->company_id;
                // $paypalInvoice->currency_id = $payment->currency_id;
                $paypalInvoice->total = $payment->total;
                $paypalInvoice->invoice_id = $eventId;
                $paypalInvoice->paid_on = $today;
                $paypalInvoice->next_payment_date = $nextPaymentDate;

                $paypalInvoice->response_data = [
                    'status' => 'paid',
                    'plan_id' => $payment->plan_id,
                    'billing_frequency' => $payment->billing_frequency,
                    'billing_interval' => 1,
                ];
                // $paypalInvoice->status = 'paid';
                // $paypalInvoice->plan_id = $payment->plan_id;
                // $paypalInvoice->billing_frequency = $payment->billing_frequency;
                // $paypalInvoice->billing_interval = 1;

                $paypalInvoice->save();

                // Change company status active after payment
                $company->status = 'active';
                $company->save();

                // TODO - Notification
                //                $generatedBy = User::whereNull('company_id')->get();
                //                $lastInvoice = PaypalInvoice::where('company_id')->count();
                //                if($lastInvoice > 1){
                //                    Notification::send($generatedBy, new CompanyUpdatedPlan($company, $payment->plan_id));
                //                }else{
                //                    Notification::send($generatedBy, new CompanyPurchasedPlan($company, $payment->plan_id));
                //                }

                return response('IPN Handled', 200);
            }
        }
    }

    public function saveAuthorizeInvoices(Request $request)
    {

        if ($request->eventType == 'net.authorize.customer.subscription.created') {
            $subscription = Subscription::authorize()->where('subscription_id', $request->payload['id'])->first();

            $package = SubscriptionPlan::find($subscription->plan_id);

            $company = Company::findOrFail($subscription->company_id);
            $authorizeInvoices = new PaymentTranscation();
            $authorizeInvoices->payment_method = 'authorize';
            $authorizeInvoices->company_id = $subscription->company_id;
            $authorizeInvoices->subscription_plan_id = $subscription->plan_id;
            $authorizeInvoices->transcation_id = $request->payload['profile']['customerPaymentProfileId'];
            $authorizeInvoices->total = $package->{$subscription->plan_type . '_price'};
            $authorizeInvoices->paid_on = Carbon::now()->format('Y-m-d');

            $packageType = $subscription->plan_type;

            if ($packageType == 'monthly') {
                $authorizeInvoices->next_payment_date = Carbon::now()->addMonth()->format('Y-m-d');
            } else {
                $authorizeInvoices->next_payment_date = Carbon::now()->addYear()->format('Y-m-d');
            }
            $authorizeInvoices->save();

            $company->subscription_plan_id = $authorizeInvoices->subscription_plan_id;
            $company->package_type = ($packageType == 'annual') ? 'annual' : 'monthly';
            $company->status = 'active';
            $company->licence_expire_on = null;
            $company->save();

            // TODO - Notification
            //send superadmin notification
            //            $generatedBy = User::allSuperAdmin();
            //            Notification::send($generatedBy, new CompanyUpdatedPlan($company, $company->package_id));
        }
    }

    public function savePaystackInvoices(Request $request)
    {
        // Log::debug($request->all());

        switch ($request['event']) {
            case "subscription.create":
                $user = User::where('email', $request['data']['customer']['email'])->first();

                $subscription = Subscription::paystack()->where('company_id', $user->company_id)->where('customer_id', $request['data']['customer']['customer_code'])->first();
                if ($subscription) {
                    $subscription->subscription_id = $request['data']['subscription_code'];
                    $subscription->token = $request['data']['email_token'];
                    $subscription->plan_id = $request['data']['plan']['plan_code'];
                    $subscription->status = 'active';
                } else {
                    $subscription = new Subscription();
                    $subscription->payment_method = 'paystack';
                    $subscription->company_id = $user->company_id;
                    $subscription->subscription_id = $request['data']['subscription_code'];
                    $subscription->token = $request['data']['email_token'];
                    $subscription->customer_id = $request['data']['customer']['customer_code'];
                    $subscription->plan_id = $request['data']['plan']['plan_code'];
                }
                $subscription->save();
                break;
            case "subscription.disable":
                $user = User::where('email', $request['data']['customer']['email'])->first();
                $subscription = Subscription::paystack()->where('company_id', $user->company_id)->where('subscription_id', $request['data']['subscription_code'])->first();
                if ($subscription) {
                    $subscription->status = 'inactive';
                    $subscription->save();
                }
                break;
            default:
                echo "Wrong event";
        }
    }

    private function getPaystackSubscriptionDetails($subscriptionCode)
    {
        $authBearer = 'Bearer ' . config('paystack.secretKey');

        $this->client = new Client(
            [
                'base_uri' => Config::get('paystack.paymentUrl'),
                'headers' => [
                    'Authorization' => $authBearer,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json'
                ]
            ]
        );

        $response = $this->client->{'get'}(
            Config::get('paystack.paymentUrl') . '/subscription/' . $subscriptionCode
        );

        return $response;
    }
}
