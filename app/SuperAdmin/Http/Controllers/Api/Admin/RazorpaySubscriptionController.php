<?php

namespace App\SuperAdmin\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiBaseController;
use App\Models\Company;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\Scopes\CompanyScope;
use App\SuperAdmin\Http\Requests\Api\Admin\RazorPayPaymentRequest;
use App\SuperAdmin\Models\GlobalCompany;
use Examyou\RestAPI\ApiResponse;
use App\SuperAdmin\Models\GlobalSettings;
use App\SuperAdmin\Models\Subscription;
use Examyou\RestAPI\Exceptions\ApiException;
use Razorpay\Api\Api;
use Vinkla\Hashids\Facades\Hashids;

class RazorpaySubscriptionController extends ApiBaseController
{

    public function razorpaySubscription(RazorPayPaymentRequest $request)
    {
        $convertedId = Hashids::decode($request->plan_id);
        $subscriptionPlanId = $convertedId[0];
        $planType =  $request->plan_type;

        $razorpaySettings = GlobalSettings::withoutGlobalScope(CompanyScope::class)
            ->where('setting_type', 'payment_settings')
            ->where('name_key', 'razorpay')
            ->first();

        $credential = (object) $razorpaySettings->credentials;

        $plan = SubscriptionPlan::find($subscriptionPlanId);

        $planID = ($planType == 'annual') ? $plan->razorpay_annual_plan_id : $plan->razorpay_monthly_plan_id;

        $apiKey    = $credential->razorpay_key;
        $secretKey = $credential->razorpay_secret;

        try {
            $api        = new Api($apiKey, $secretKey);
            $subscription  = $api->subscription->create(array('plan_id' => $planID, 'customer_notify' => 1, 'total_count' => 2));

            return ApiResponse::make('Success', [
                'subscriprion' => $subscription->id,
            ]);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

    public function razorpayPayment()
    {
        $request = request();
        $razorpaySettings = GlobalSettings::withoutGlobalScope(CompanyScope::class)
            ->where('setting_type', 'payment_settings')
            ->where('name_key', 'razorpay')
            ->first();
        $credential = (object) $razorpaySettings->credentials;

        $apiKey    = $credential->razorpay_key;
        $secretKey = $credential->razorpay_secret;

        $paymentId = $request->payment_id;
        $razorpaySignature = $request->razorpay_signature;
        $subscriptionId = $request->subscription_id;

        $api = new Api($apiKey, $secretKey);

        $convertedId = Hashids::decode($request->plan_id);
        $subscriptionPlanId = $convertedId[0];
        $plan = SubscriptionPlan::find($subscriptionPlanId);
        $type = $request->type;

        $expectedSignature = hash_hmac('sha256', $paymentId . '|' . $subscriptionId, $secretKey);

        if ($expectedSignature === $razorpaySignature) {
            $productCount = Product::count();

            if ($plan->max_characters < $productCount) {
                throw new ApiException('You can not downgrade plan because you have ' . $productCount . ' products while your new plan allow max characters ' . $plan->max_characters);
            }

            try {
                $api->payment->fetch($paymentId);
                // Returns a particular payment
                $payment = $api->payment->fetch($paymentId);

                if ($payment->status == 'authorized') {
                    $globalCompany = GlobalCompany::select('id', 'currency_id')
                        ->with(['currency' => function ($query) {
                            return $query->withoutGlobalScope(CompanyScope::class)
                                ->select('id', 'name', 'position', 'symbol', 'code');
                        }])
                        ->first();

                    //TODO::change INR into default currency code
                    $payment->capture(array('amount' => $payment->amount, 'currency' => $globalCompany->currency->code));
                }

                $company = Company::find(company()->id);
                $company->subscription_plan_id = $plan->id;
                $company->package_type = $type;
                // Set company status active
                $company->status = 'active';
                $company->licence_expire_on = null;
                $company->save();


                $subscription = new Subscription();
                $subscription->payment_method = 'razorpay';
                $subscription->subscription_id = $subscriptionId;
                $subscription->company_id      = $company->id;
                $subscription->stripe_id     = $paymentId;
                $subscription->plan_type   = $type;
                $subscription->quantity        = 1;
                $subscription->save();

                // TODO - Notification
                //send superadmin notification
                //                $generatedBy = User::whereNull('company_id')->get();
                //                Notification::send($generatedBy, new CompanyUpdatedPlan($company, $plan->id));

                return ApiResponse::make('Success', [
                    'success' => true,
                    'message' => 'Payment successfully done.',
                ]);
            } catch (\Exception $e) {
                return ApiResponse::make('Success', [
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }
}
