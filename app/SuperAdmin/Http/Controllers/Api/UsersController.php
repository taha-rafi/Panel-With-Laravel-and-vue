<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\SuperAdmin\Http\Requests\Api\User\IndexRequest;
use App\SuperAdmin\Http\Requests\Api\User\StoreRequest;
use App\SuperAdmin\Http\Requests\Api\User\UpdateRequest;
use App\SuperAdmin\Http\Requests\Api\User\DeleteRequest;
use App\Models\SuperAdmin;
use Examyou\RestAPI\Exceptions\ApiException;

class UsersController extends ApiBaseController
{
    protected $model = SuperAdmin::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function storing(SuperAdmin $superAdmin)
    {
        $company = company();

        $superAdmin->company_id = $company->id;
        $superAdmin->user_type = "super_admins";
        $superAdmin->is_superadmin = 1;

        return $superAdmin;
    }

    public function destroying($user)
    {
        if ($user->user_type != "super_admins") {
            throw new ApiException("Don't have valid permission");
        }

        $loggedUser = user();
        $loggedUserCompany = company();

        if ($loggedUserCompany->admin_id == $user->id) {
            throw new ApiException('Can not delete company root super admin');
        }

        if (env('APP_ENV') == 'production' && $user->user_type == 'super_admins' && ($user->getOriginal('email') == 'superadmin@example.com')) {
            throw new ApiException('Not Allowed In Demo Mode');
        }

        // If application have only one admin
        // Then staff member cannot be deleted
        if ($user->user_type == "super_admins") {
            $superAdminCount = SuperAdmin::count();

            if ($superAdminCount <= 1) {
                throw new ApiException("Can not delete superadmin because this is only single superadmin.");
            }
        }

        if ($loggedUser->id == $user->id) {
            throw new ApiException('Can not delete yourself.');
        }

        return $user;
    }
}
