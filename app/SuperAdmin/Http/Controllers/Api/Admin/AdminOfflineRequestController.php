<?php

namespace App\SuperAdmin\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\Admin\SubmitOfflinePaymentRequest;
use App\SuperAdmin\Http\Requests\Api\OfflineRequest\IndexRequest;
use App\SuperAdmin\Models\PaymentTranscation;
use Examyou\RestAPI\ApiResponse;

class AdminOfflineRequestController extends ApiBaseController
{
    protected $model = PaymentTranscation::class;

    protected $indexRequest = IndexRequest::class;

    public function modifyIndex($query)
    {
        $query = $query->offlineRequests();

        return $query;
    }

    public function submitOfflineRequest(SubmitOfflinePaymentRequest $request)
    {
        $loggedUser = user();
        $loggedUserCompany = company();

        $subscriptionPlanId = $this->getIdFromHash($request->subscription_plan_id);
        $offlinePaymentId = $this->getIdFromHash($request->offline_payment_mode_id);

        $offlineRequest = new PaymentTranscation();
        $offlineRequest->payment_method = "offline";
        $offlineRequest->company_id = $loggedUserCompany->id;
        $offlineRequest->subscription_plan_id = $subscriptionPlanId;
        $offlineRequest->plan_type = $request->plan_type;
        $offlineRequest->status = 'pending';
        $offlineRequest->proof_document = $request->proof_document;
        $offlineRequest->submit_description = $request->submit_description;
        $offlineRequest->submitted_by_id = $loggedUser->id;
        $offlineRequest->offline_payment_mode_id = $offlinePaymentId;
        $offlineRequest->is_offline_request = 1;
        $offlineRequest->save();

        return ApiResponse::make('Success', []);
    }
}
