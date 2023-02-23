<?php

namespace App\SuperAdmin\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Models\Company;
use App\SuperAdmin\Models\GlobalCompany;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Support\Facades\Storage;

class DashboardController extends ApiBaseController
{
    public function dashboard()
    {
        $totalCompaniesCount = Company::count();
        $activeCompaniesCount = Company::where('status', '=', 'active')->count();
        $inactiveCompaniesCount = Company::where('status', '=', 'inactive')->count();
        $expiredCompaniesCount =  Company::with('subscriptionPlan')->where('status', 'license_expired')->count();

        return ApiResponse::make('Success', [
            'stats' => [
                'totalCompaniesCount' => $totalCompaniesCount,
                'activeCompaniesCount' => $activeCompaniesCount,
                'inactiveCompaniesCount' => $inactiveCompaniesCount,
                'expiredCompaniesCount' => $expiredCompaniesCount,
            ],
        ]);
    }

    public function defaultLogoDetails()
    {
        return ApiResponse::make('Success', [
            'light_logo' => 'light.png',
            'light_logo_url' => asset('images/light.png'),
            'dark_logo' => 'dark.png',
            'dark_logo_url' => asset('images/dark.png'),
            'small_dark_logo' => 'small_dark.png',
            'small_dark_logo_url' => asset('images/small_dark.png'),
            'small_light_logo' => 'small_light.png',
            'small_light_logo_url' => asset('images/small_light.png'),
        ]);
    }

    public function whiteLabelCompleted()
    {
        $globalCompany = GlobalCompany::first();
        $globalCompany->white_label_completed = 1;
        $globalCompany->save();

        return ApiResponse::make('Success', []);
    }

    public function uploadDefaultLogo()
    {
        $request = request();
        $imageName = $request->image_field;

        if ($imageName == 'dark_logo') {
            $fileName   = 'dark.png';
        } else if ($imageName == 'light_logo') {
            $fileName   = 'light.png';
        } else if ($imageName == 'small_dark_logo') {
            $fileName   = 'small_dark.png';
        } else if ($imageName == 'small_light_logo') {
            $fileName   = 'small_light.png';
        }

        if ($request->hasFile('image')) {
            $largeLogo  = $request->file('image');

            if ($largeLogo->getClientOriginalExtension() != 'png') {
                throw new ApiException('Extension must be png');
            }

            $largeLogo->move(public_path('images'), $fileName);

            return ApiResponse::make('Success', [
                'file' => $fileName,
                'file_url' => asset('images/' . $fileName),
            ]);
        }
    }
}
