<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Classes\Common;
use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\Company\IndexRequest;
use App\SuperAdmin\Http\Requests\Api\Company\StoreRequest;
use App\SuperAdmin\Http\Requests\Api\Company\UpdateRequest;
use App\SuperAdmin\Http\Requests\Api\Company\DeleteRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\StaffMember;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Warehouse;
use App\SuperAdmin\Http\Requests\Api\Company\ChangeSubscriptionPlanRequest;
use App\SuperAdmin\Models\PaymentTranscation;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Support\Str;

class CompanyController extends ApiBaseController
{
    protected $model = Company::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function storing(Company $company)
    {
        $company->verified = 0;
        $company->is_global = 0;
        $company->email_verification_code = Str::random(50);

        return $company;
    }

    public function stored(Company $company)
    {
        $request = request();

        $admin = StaffMember::create([
            'company_id' => $company->id,
            'name' => "Admin",
            'email' => $request->user_email,
            'password' => $request->user_password,
            'user_type' => 'staff_members',
            'email_verification_code' => Str::random(50),
            'status' => 'enabled',
        ]);

        $adminRole = Role::withoutGlobalScope(CompanyScope::class)->where('name', 'admin')->where('company_id', $company->id)->first();

        $admin->role_id = $adminRole->id;
        $admin->save();
        $admin->roles()->attach($adminRole->id);


        $company->admin_id = $admin->id;
        $company->save();

        // TODO - Sending verification email

        return $company;
    }

    public function updating(Company $company)
    {
        if (env('APP_ENV') == 'production' && $company->email == 'company@example.com' && ($company->isDirty('name') ||
            $company->isDirty('short_name') || $company->isDirty('light_logo') ||
            $company->isDirty('dark_logo') || $company->isDirty('small_dark_logo') ||
            $company->isDirty('small_light_logo') || $company->isDirty('app_debug') ||
            $company->isDirty('update_app_notification') || $company->isDirty('app_debug')
        )) {
            throw new ApiException('Not Allowed In Demo Mode');
        }

        $request = request();

        // Total Users
        $totalUsers = Common::calculateTotalUsers($company->id);
        $company->total_users = $totalUsers;
        $company->save();

        // For updating company admin email and password
        $companyAdminId = $company->admin_id;
        if ($companyAdminId != '') {
            $companyAdmin = User::find($companyAdminId);
            $companyAdmin->email = $request->user_email;
            $companyAdmin->password = $request->user_password;
            $companyAdmin->save();
        }

        return $company;
    }

    public function changeSubscriptionPlan(ChangeSubscriptionPlanRequest $request)
    {
        $companyId = $this->getIdFromHash($request->company_id);
        $subscriptionPlanId = $this->getIdFromHash($request->subscription_plan_id);
        $offlinePaymentModeId = $this->getIdFromHash($request->offline_payment_mode_id);
        $planType = $request->plan_type;

        // Check if offlineRequestId is already approved or not

        $company = Company::find($companyId);

        $paymentTranscation = new PaymentTranscation();
        $paymentTranscation->company_id = $company->id;
        $paymentTranscation->payment_method = "offline";
        $paymentTranscation->subscription_plan_id = $subscriptionPlanId;
        $paymentTranscation->next_payment_date = $request->license_expires_on;
        $paymentTranscation->offline_payment_mode_id = $offlinePaymentModeId;
        $paymentTranscation->paid_on = $request->paid_on;
        $paymentTranscation->plan_type = $request->plan_type;
        $paymentTranscation->total = $request->amount;
        $paymentTranscation->status = 'approved';
        $paymentTranscation->save();

        $company->subscription_plan_id = $subscriptionPlanId;
        $company->package_type = $planType;

        // Set company status active
        $company->status = 'active';
        $company->licence_expire_on = $request->license_expires_on;
        $company->payment_transcation_id = $paymentTranscation->id;
        $company->save();



        return ApiResponse::make('Success', []);
    }
}
