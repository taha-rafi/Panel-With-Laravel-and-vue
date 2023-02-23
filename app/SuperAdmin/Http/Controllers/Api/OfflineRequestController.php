<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Models\Company;
use App\Models\SubscriptionPlan;
use App\Scopes\CompanyScope;
use App\SuperAdmin\Http\Requests\Api\OfflineRequest\ApproveOfllineRequest;
use App\SuperAdmin\Http\Requests\Api\OfflineRequest\IndexRequest;
use App\SuperAdmin\Http\Requests\Api\OfflineRequest\RejectOfllineRequest;
use App\SuperAdmin\Models\PaymentTranscation;
use Examyou\RestAPI\ApiResponse;
use Illuminate\Support\Facades\DB;

class OfflineRequestController extends ApiBaseController
{
    protected $model = PaymentTranscation::class;

    protected $indexRequest = IndexRequest::class;

    public function modifyIndex($query)
    {
        $query = $query->withoutGlobalScope(CompanyScope::class)
            ->offlineRequests();

        return $query;
    }

    public function approveOfflineRequest(ApproveOfllineRequest $request)
    {
        $offlineRequestId = $this->getIdFromHash($request->offline_request_id);
        $subscriptionPlanId = $this->getIdFromHash($request->subscription_plan_id);
        $offlinePaymentModeId = $this->getIdFromHash($request->offline_payment_mode_id);

        // Check if offlineRequestId is already approved or not
        $offlineRequest = PaymentTranscation::offlineRequests()
            ->where('status', 'pending')
            ->where('id', $offlineRequestId)->first();

        if ($offlineRequest) {
            $company = Company::find($offlineRequest->company_id);

            $company->subscription_plan_id = $subscriptionPlanId;
            $company->package_type = $offlineRequest->plan_type;

            // Set company status active
            $company->status = 'active';
            $company->licence_expire_on = $request->license_expires_on;
            $company->payment_transcation_id = $offlineRequest->id;
            $company->save();

            $offlineRequest->subscription_plan_id = $subscriptionPlanId;
            $offlineRequest->next_payment_date = $request->license_expires_on;
            $offlineRequest->offline_payment_mode_id = $offlinePaymentModeId;
            $offlineRequest->paid_on = $request->paid_on;
            $offlineRequest->plan_type = $request->plan_type;
            $offlineRequest->total = $request->amount;
            $offlineRequest->status = 'approved';
            $offlineRequest->save();

            $subscriptionPlan = SubscriptionPlan::find($subscriptionPlanId);

            if ($subscriptionPlan) {
                // Saving Added Character
                DB::table('added_characters')->insert([
                    'company_id' => $company->id,
                    'character_count' => $subscriptionPlan->max_characters,
                    'notes' => 'Added for offline payment',
                    'payment_transcation_id' => $offlineRequest->id,
                ]);
            }
        }

        return ApiResponse::make('Success', []);
    }

    public function rejectOfflineRequest(RejectOfllineRequest $request)
    {
        $offlineRequestId = $this->getIdFromHash($request->offline_request_id);

        // Check if offlineRequestId is already approved or not
        $offlineRequest = PaymentTranscation::offline()
            ->where('status', 'pending')
            ->where('id', $offlineRequestId)->first();

        if ($offlineRequest) {
            $offlineRequest->status = 'rejected';
            $offlineRequest->save();
        }

        return ApiResponse::make('Success', []);
    }
}
