<?php

namespace App\SuperAdmin\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiBaseController;
use App\Models\Company;
use App\Models\PaymentGatewaySettings;
use App\Models\Subscription;
use App\Models\PaypalInvoice;
use App\Models\SubscriptionPlan;
use App\Scopes\CompanyScope;
use App\SuperAdmin\Models\GlobalCompany;
use App\SuperAdmin\Models\GlobalSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Common\PayPalModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Vinkla\Hashids\Facades\Hashids;

/** All Paypal Details class **/

use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use Carbon\Carbon;
use Examyou\RestAPI\ApiResponse;

class AdminPaypalController extends ApiBaseController
{
    private $_api_context;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $razorpaySettings = GlobalSettings::withoutGlobalScope(CompanyScope::class)
            ->where('setting_type', 'payment_settings')
            ->where('name_key', 'razorpay')
            ->first();
        $credential = (object) $razorpaySettings->credentials;

        /** setup PayPal api context **/
        config(['paypal.settings.mode' => $credential->paypal_mode]);
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($credential->paypal_client_id, $credential->paypal_secret));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function paymentWithpaypal($planId, $type)
    {
        $request = request();
        $convertedId = Hashids::decode($planId);
        $subscriptionPlanId = $convertedId[0];
        $subscriptionPlan = SubscriptionPlan::where('id', $subscriptionPlanId)->first();
        $company = Company::find(company()->id);

        if ($type == 'annual') {
            $totalAmount = $subscriptionPlan->annual_price;
            $frequency = 'year';
            $cycle = 0;
        } else {
            $totalAmount = $subscriptionPlan->monthly_price;
            $frequency = 'month';
            $cycle = 0;
        }
        // $this->companyName = $this->company->name;

        $globalCompany = GlobalCompany::select('id', 'currency_id')
            ->with(['currency' => function ($query) {
                return $query->withoutGlobalScope(CompanyScope::class)
                    ->select('id', 'name', 'position', 'symbol', 'code');
            }])
            ->first();


        $plan = new Plan();
        $plan->setName('#' . $subscriptionPlan->name)
            ->setDescription('Payment for subscriptionPlanId ' . $subscriptionPlan->name)
            ->setType('INFINITE');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Payment for subscriptionPlanId ' . $subscriptionPlan->name)
            ->setType('REGULAR')
            ->setFrequency(strtoupper($frequency))
            ->setFrequencyInterval(1)
            ->setCycles($cycle)
            ->setAmount(new Currency(array('value' => $totalAmount, 'currency' => $globalCompany->currency->code)));

        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(route('admin.paypal-recurring') . "?success=true&invoice_id=" . $subscriptionPlanId)
            ->setCancelUrl(route('admin.paypal-recurring') . "?success=false&invoice_id=" . $subscriptionPlanId)
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0");
        //            ->setSetupFee(new Currency(array('value' => $totalAmount, 'currency' => $globalCompany->currency->currency_code)));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        try {
            $output = $plan->create($this->_api_context);
        } catch (\Exception $ex) {
            return ApiResponse::make('Success', [
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }

        try {
            $patch = new Patch();
            $value = new PayPalModel('{
               "state":"ACTIVE"
             }');
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);

            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);
            $output->update($patchRequest, $this->_api_context);
            $newPlan = Plan::get($output->getId(), $this->_api_context);
        } catch (\Exception $ex) {
            return ApiResponse::make('Success', [
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }

        // Calculating next billing date
        $today = Carbon::now()->addDays(1); //payment will deduct after 1 day

        $startingDate = $today->toIso8601String();


        $agreement = new Agreement();
        $agreement->setName($subscriptionPlan->name)
            ->setDescription('Payment for subscriptionPlanId # ' . $subscriptionPlan->name)
            ->setStartDate("$startingDate");

        $plan1 = new Plan();
        $plan1->setId($newPlan->getId());
        $agreement->setPlan($plan1);

        // Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        // ### Create Agreement
        try {
            // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
            $agreement = $agreement->create($this->_api_context);

            $approvalUrl = $agreement->getApprovalLink();
        } catch (\Exception $ex) {
            return ApiResponse::make('Success', [
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $newPlan->getId());

        $paypalInvoice = new PaypalInvoice();
        $paypalInvoice->company_id = $this->company->id;
        $paypalInvoice->subscription_plan_id = $subscriptionPlanId->id;
        $paypalInvoice->currency_id = $globalCompany->currency->id;
        $paypalInvoice->total = $totalAmount;
        $paypalInvoice->status = 'pending';
        $paypalInvoice->plan_id = $newPlan->getId();
        $paypalInvoice->billing_frequency = $frequency;
        $paypalInvoice->billing_interval = 1;
        $paypalInvoice->save();

        if (isset($approvalUrl)) {
            /** redirect to paypal **/
            return Redirect::away($approvalUrl);
        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('admin.subscription-plan.index');
    }

    public function payWithPaypalRecurrring(Request $requestObject)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        $clientPayment =  PaypalInvoice::where('plan_id', $payment_id)->first();
        $company = $this->company;
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if ($requestObject->get('success') == true && $requestObject->has('token') && $requestObject->get('success') != "false") {
            $token = $requestObject->get('token');
            $agreement = new Agreement();

            try {
                // ## Execute Agreement
                // Execute the agreement by passing in the token
                $agreement->execute($token, $this->_api_context);


                if ($agreement->getState() == 'Active' || $agreement->getState() == 'Pending') {

                    $this->cancelSubscription();
                    // Calculating next billing date
                    $today = Carbon::now();


                    $clientPayment->transaction_id = $agreement->getId();
                    if ($agreement->getState() == 'Active') {
                        $clientPayment->status = 'paid';
                    }
                    $clientPayment->paid_on = Carbon::now();
                    $clientPayment->save();

                    $company->subscription_plan_id = $clientPayment->subscription_plan_id;
                    $company->package_type = ($clientPayment->billing_frequency == 'year') ? 'annual' : 'monthly';
                    $company->status = 'active'; // Set company status active
                    $company->licence_expire_on = null;
                    $company->save();

                    if ($company->package_type == 'monthly') {
                        $today = $today->addMonth();
                    } else {
                        $today = $today->addYear();
                    }

                    $clientPayment->next_pay_date = $today->format('Y-m-d');
                    $clientPayment->save();

                    // TODO - Notification
                    //send superadmin notification
                    //                    $generatedBy = User::whereNull('company_id')->get();
                    //                    Notification::send($generatedBy, new CompanyUpdatedPlan($company, $clientPayment->package_id));

                    \Session::put('success', 'Payment successfully done');
                    return Redirect::route('admin.subscription-plan.index');
                }

                \Session::put('error', 'Payment failed');

                return Redirect::route('admin.subscription-plan.index');
            } catch (PayPalConnectionException $ex) {
                $errCode = $ex->getCode();
                $errData = json_decode($ex->getData());
                if ($errCode == 400 && $errData->name == 'INVALID_CURRENCY') {
                    \Session::put('error', $errData->message);
                    return Redirect::route('admin.subscription-plan.index');
                } elseif (\Config::get('app.debug')) {
                    \Session::put('error', 'Connection timeout');
                    return Redirect::route('admin.subscription-plan.index');
                } else {
                    \Session::put('error', 'Some error occur, sorry for inconvenient');
                    return Redirect::route('admin.subscription-plan.index');
                }
            }
        } else if ($requestObject->get('fail') == true || $requestObject->get('success') == "false") {
            \Session::put('error', 'Payment failed');

            return Redirect::route('admin.subscription-plan.index');
        } else {
            abort(403);
        }
    }

    public function cancelSubscription()
    {
        $company = $this->company;
        $stripe = DB::table("stripe_invoices")
            ->join('subscription_plans', 'subscription_plans.id', 'stripe_invoices.subscription_plan_id')
            ->selectRaw('stripe_invoices.id , "Stripe" as method, stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date')
            ->whereNotNull('stripe_invoices.pay_date')
            ->where('stripe_invoices.company_id', $this->company->id);

        $allInvoices = DB::table("paypal_invoices")
            ->join('subscription_plans', 'subscription_plans.id', 'paypal_invoices.subscription_plan_id')
            ->selectRaw('paypal_invoices.id, "Paypal" as method, paypal_invoices.paid_on,paypal_invoices.next_pay_date')
            ->where('paypal_invoices.status', 'paid')
            ->whereNull('paypal_invoices.end_on')
            ->where('paypal_invoices.company_id', $this->company->id)
            ->union($stripe)
            ->get();

        $firstInvoice = $allInvoices->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->paid_on)->getTimestamp();
        })->first();

        if (!is_null($firstInvoice) && $firstInvoice->method == 'Paypal') {
            $credential = PaymentGatewaySettings::first();
            config(['paypal.settings.mode' => $credential->paypal_mode]);
            $paypal_conf = Config::get('paypal');
            $api_context = new ApiContext(new OAuthTokenCredential($credential->paypal_client_id, $credential->paypal_secret));
            $api_context->setConfig($paypal_conf['settings']);

            $paypalInvoice = PaypalInvoice::whereNotNull('transaction_id')->whereNull('end_on')
                ->where('company_id', $this->company->id)->where('status', 'paid')->first();

            if ($paypalInvoice) {
                $agreementId = $paypalInvoice->transaction_id;
                $agreement = new Agreement();

                $agreement->setId($agreementId);
                $agreementStateDescriptor = new AgreementStateDescriptor();
                $agreementStateDescriptor->setNote("Cancel the agreement");

                try {
                    $agreement->cancel($agreementStateDescriptor, $api_context);
                    $cancelAgreementDetails = Agreement::get($agreement->getId(), $api_context);

                    // Set subscription end date
                    $paypalInvoice->end_on = Carbon::parse($cancelAgreementDetails->agreement_details->final_payment_date)->format('Y-m-d H:i:s');
                    $paypalInvoice->save();

                    $company->licence_expire_on = $paypalInvoice->end_on;
                    $company->save();
                } catch (\Exception $ex) {
                    // \Session::put('error','Some error occur, sorry for inconvenient');
                }
            }
        } elseif (!is_null($firstInvoice) && $firstInvoice->method == 'Stripe') {
            $this->setStripConfigs();

            $subscription = Subscription::where('company_id', $this->company->id)->whereNull('ends_at')->first();
            if ($subscription) {
                try {
                    $company->subscription('main')->cancel();

                    $company->licence_expire_on = $subscription->ends_at;
                    $company->save();
                } catch (\Exception $ex) {
                    //\Session::put('error','Some error occur, sorry for inconvenient');
                }
            }
        }
    }

    public function paypalInvoiceDownload($id)
    {
        //        header('Content-type: application/pdf');
        $this->invoice = PaypalInvoice::with(['company', 'currency', 'subscriptionPlan'])->findOrFail($id);
        //        $this->settings = $this->company;
        //        return view('invoices.'.$this->invoiceSetting->template, $this->data);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.invoices.paypal-invoice', $this->data);
        $filename = 'invoice-' . $this->invoice->paid_on->format($this->user->date_format);
        //       return $pdf->stream();
        return $pdf->download($filename . '.pdf');
    }
}
