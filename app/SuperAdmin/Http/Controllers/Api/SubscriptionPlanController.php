<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\SubscriptionPlan\IndexRequest;
use App\SuperAdmin\Http\Requests\Api\SubscriptionPlan\StoreRequest;
use App\SuperAdmin\Http\Requests\Api\SubscriptionPlan\UpdateRequest;
use App\SuperAdmin\Http\Requests\Api\SubscriptionPlan\DeleteRequest;
use App\Models\SubscriptionPlan;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;

class SubscriptionPlanController extends ApiBaseController
{
    protected $model = SubscriptionPlan::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function modifyIndex($query)
    {
        $query = $query->where('default', '!=', 'trial');

        return $query;
    }

    public function storing(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->default = 'no';

        return $subscriptionPlan;
    }

    public function destroying(SubscriptionPlan $subscriptionPlan)
    {
        // Trail and Default Plan Can not be deleted
        if ($subscriptionPlan->default == 'trial' || $subscriptionPlan->default == 'yes') {
            throw new ApiException('Default plan can not be deleted');
        }

        return $subscriptionPlan;
    }

    public function trailPlan()
    {
        $plan = SubscriptionPlan::where('default', 'trial')->first();

        return ApiResponse::make(
            'Success',
            [
                'plan' => $plan,
            ]
        );
    }
}
