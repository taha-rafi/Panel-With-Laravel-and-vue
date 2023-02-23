<?php

namespace App\SuperAdmin\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiBaseController;
use App\Models\Company;
use App\Models\SubscriptionPlan;
use App\Scopes\CompanyScope;
use App\SuperAdmin\Classes\SuperAdminCommon;
use App\SuperAdmin\Models\GlobalCompany;
use App\SuperAdmin\Models\PaymentTranscation;
use Examyou\RestAPI\ApiResponse;
use App\SuperAdmin\Http\Requests\Api\PaymentTranscation\IndexRequest;
use App\SuperAdmin\Models\OfflinePaymentMode;

class AdminSubscriptionController extends ApiBaseController
{
    protected $model = PaymentTranscation::class;

    protected $indexRequest = IndexRequest::class;

    public function modifyIndex($query)
    {
        $query = $query->allTranscations();

        return $query;
    }

    public function subscribePlanDetails()
    {
        $user = auth('api')->user();

        $globalCompany = GlobalCompany::select('id', 'currency_id')
            ->with(['currency' => function ($query) {
                return $query->withoutGlobalScope(CompanyScope::class)
                    ->select('id', 'name', 'position', 'symbol', 'code');
            }])
            ->first();

        $currentSubscriptionPlan = Company::withoutGlobalScope('company')->with(['subscriptionPlan' => function ($query) use ($user) {
            return $query->select('id', 'name', 'modules', 'max_characters', 'monthly_price', 'annual_price', 'default');
        }])->where('id', $user->company_id)->select('id', 'subscription_plan_id', 'payment_transcation_id')->first();

        $lastPaymentTranscation = PaymentTranscation::find($currentSubscriptionPlan->payment_transcation_id);

        return ApiResponse::make('Success', [
            'currency' => $globalCompany->currency,
            'last_payment_transcation' => $lastPaymentTranscation,
            'current_subscription_plan' => $currentSubscriptionPlan->subscriptionPlan,
        ]);
    }

    public function allSubscriptionPlans()
    {
        $globalCompany = GlobalCompany::select('id', 'currency_id')
            ->with(['currency' => function ($query) {
                return $query->withoutGlobalScope(CompanyScope::class)
                    ->select('id', 'name', 'position', 'symbol', 'code');
            }])
            ->first();

        $allSubscriptionPlans = SubscriptionPlan::where('default', 'no')->get();

        return ApiResponse::make('Success', [
            'currency' => $globalCompany->currency,
            'all_subscription_plans' => $allSubscriptionPlans,
        ]);
    }

    public function allPaymentMethodSettings()
    {
        $allPaymentMethods = SuperAdminCommon::getAppPaymentSettings();
        $allPaymentOfflineModes = OfflinePaymentMode::select('id', 'name', 'description')->get();

        return ApiResponse::make('Success', [
            'payment_methods' => $allPaymentMethods,
            'offline_payment_modes' => $allPaymentOfflineModes,
        ]);
    }
}
