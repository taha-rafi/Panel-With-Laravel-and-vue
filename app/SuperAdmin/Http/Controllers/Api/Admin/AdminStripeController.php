<?php

namespace App\SuperAdmin\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiBaseController;
use App\Models\Company;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\SuperAdmin\Models\PaymentTranscation;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;
use Vinkla\Hashids\Facades\Hashids;
use App\SuperAdmin\Traits\StripeSettings;
use App\SuperAdmin\Http\Requests\Api\Admin\StripePaymentRequest;
use Illuminate\Support\Facades\DB;

class AdminStripeController extends ApiBaseController
{
    use StripeSettings;

    public function stripePayment(StripePaymentRequest $request)
    {
        $this->setStripConfigs();
        $token = $request->stripe_token;
        $email = $request->email;
        $planType = $request->plan_type;

        $convertedId = Hashids::decode($request->plan_id);
        $planId = $convertedId[0];

        // Check if subscription plan exists or not
        $plan = SubscriptionPlan::find($planId);
        if (!$plan) {
            throw new ApiException('Subscription Plan Not Exists');
        }

        $lastPaymentTranscation = PaymentTranscation::online()->with(['subscriptionPlan'])->whereNotNull('paid_on')->latest()->first();

        $subcriptionCancel = true;

        if (!is_null($lastPaymentTranscation) && $lastPaymentTranscation->payment_method == 'paypal') {
            $subcriptionCancel = $this->cancelSubscriptionPaypal();
        }
        if (!is_null($lastPaymentTranscation) && $lastPaymentTranscation->payment_method == 'razorpay') {
            $subcriptionCancel = $this->cancelSubscriptionRazorpay();
        }

        if ($subcriptionCancel) {

            $company = Company::find(company()->id);
            $subscription = $company->subscriptions;

            try {
                if ($subscription->count() > 0) {
                    $company->subscription('main')->swap($plan->{'stripe_' . $planType . '_plan_id'});
                } else {

                    $company->newSubscription('main', $plan->{'stripe_' . $planType . '_plan_id'})->create($token, [
                        'email' => $email,
                    ]);
                }

                $company->subscription_plan_id = $plan->id;
                $company->package_type = $planType;

                // Set company status active
                $company->status = 'active';
                $company->licence_expire_on = null;

                $company->save();

                if ($plan) {
                    // Saving Added Character
                    DB::table('added_characters')->insert([
                        'company_id' => $company->id,
                        'character_count' => $plan->max_characters,
                        'notes' => 'Added for offline payment',
                        'payment_transcation_id' => $lastPaymentTranscation->id,
                    ]);
                }

                //send superadmin notification
                // $generatedBy = User::whereNull('company_id')->get();
                //Notification::send($generatedBy, new CompanyUpdatedPlan($company, $plan->id));

                return ApiResponse::make('Success', [
                    'success' => true,
                    'message' => 'Payment successfully done.',
                ]);

                return redirect(route('admin.subscription-plan.subscribe'));
            } catch (\Exception $e) {
                return ApiResponse::make('Success', [
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }
}
