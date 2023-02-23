<?php

namespace App\Http\Controllers\Api;

use App\Classes\Common;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\ProfileRequest;
use App\Http\Requests\Api\Auth\RefreshTokenRequest;
use App\Http\Requests\Api\Auth\UploadFileRequest;
use App\Models\Company;
use App\Models\Lang;
use App\Models\Settings;
use App\Models\UsedCharacter;
use App\Models\User;
use App\Models\WorkSpace;
use App\Models\WriterCategory;
use App\Models\WriterDocument;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends ApiBaseController
{
    public function companySetting()
    {
        $settings = Company::first();

        return ApiResponse::make('Success', [
            'global_setting' => $settings,
        ]);
    }

    public function emailSettingVerified()
    {
        $emailSettingVerified = Settings::where('setting_type', 'email')
            ->where('status', 1)
            ->where('verified', 1)
            ->count();

        return $emailSettingVerified > 0 ? 1 : 0;
    }

    public function app()
    {
        $company = company(true);

        return ApiResponse::make('Success', [
            'app' => $company,
            'email_setting_verified' => $this->emailSettingVerified(),
        ]);
    }

    public function checkSubscriptionModuleVisibility()
    {
        $request = request();
        $itemType = $request->item_type;

        $visible = Common::checkSubscriptionModuleVisibility($itemType);

        return ApiResponse::make('Success', [
            'visible' => $visible,
        ]);
    }

    public function visibleSubscriptionModules()
    {
        $visibleSubscriptionModules = Common::allVisibleSubscriptionModules();

        return ApiResponse::make('Success', $visibleSubscriptionModules);
    }

    public function allEnabledLangs()
    {
        $allLangs = Lang::select('id', 'name', 'key', 'image')->where('enabled', 1)->get();

        return ApiResponse::make('Success', [
            'langs' => $allLangs
        ]);
    }

    public function allCategories()
    {
        $allCateogires = WriterCategory::select('id', 'name', 'logo')->get();

        return ApiResponse::make('Success', [
            'categories' => $allCateogires
        ]);
    }

    public function login(LoginRequest $request)
    {
        // Removing all sessions before login
        session()->flush();

        $phone = "";
        $email = "";

        $credentials = [
            'password' =>  $request->password
        ];

        if (is_numeric($request->get('email'))) {
            $credentials['phone'] = $request->email;
            $phone = $request->email;
        } else {
            $credentials['email'] = $request->email;
            $email = $request->email;
        }

        // For checking user
        $user = User::select('*');
        if ($email != '') {
            $user = $user->where('email', $email);
        } else if ($phone != '') {
            $user = $user->where('phone', $phone);
        }
        $user = $user->first();

        // Adding user type according to email/phone
        if ($user) {
            $credentials['user_type'] = 'staff_members';
            $credentials['is_superadmin'] = 0;
            $userCompany = Company::where('id', $user->company_id)->first();
        }

        if (!$token = auth('api')->attempt($credentials)) {
            throw new ApiException('These credentials do not match our records.');
        } else if ($userCompany->status === 'pending') {
            throw new ApiException('Your company not verified.');
        } else if ($userCompany->status === 'inactive') {
            throw new ApiException('Company account deactivated.');
        } else if (auth('api')->user()->status === 'waiting') {
            throw new ApiException('User not verified.');
        } else if (auth('api')->user()->status === 'disabled') {
            throw new ApiException('Account deactivated.');
        }

        $company = company();
        $response = $this->respondWithToken($token);
        $response['app'] = $company;
        $response['email_setting_verified'] = $this->emailSettingVerified();
        $response['visible_subscription_modules'] = Common::getRemainingCharacters();

        return ApiResponse::make('Loggged in successfull', $response);
    }

    protected function respondWithToken($token)
    {
        $user = user();

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Carbon::now()->addDays(180),
            'user' => $user
        ];
    }

    public function logout()
    {
        $request = request();

        if (auth('api')->user() && $request->bearerToken() != '') {
            auth('api')->logout();
        }

        session()->flush();

        return ApiResponse::make(__('Session closed successfully'));
    }

    public function user()
    {
        $user = auth('api')->user();
        $user = $user->load('role', 'role.perms');

        session(['user' => $user]);

        return ApiResponse::make('Data successfull', [
            'user' => $user
        ]);
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        $newToken = auth('api')->refresh();

        $response = $this->respondWithToken($newToken);

        return ApiResponse::make('Token fetched successfully', $response);
    }

    public function uploadFile(UploadFileRequest $request)
    {
        $result = Common::uploadFile($request);

        return ApiResponse::make('File Uploaded', $result);
    }

    public function profile(ProfileRequest $request)
    {
        $user = auth('api')->user();

        // In Demo Mode
        if (env('APP_ENV') == 'production') {
            $request = request();

            if ($request->email == 'admin@example.com' && $request->has('password') && $request->password != '') {
                throw new ApiException('Not Allowed In Demo Mode');
            }
        }

        $user->name = $request->name;
        if ($request->has('profile_image')) {
            $user->profile_image = $request->profile_image;
        }
        if ($request->password != '') {
            $user->password = $request->password;
        }
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return ApiResponse::make('Profile updated successfull', [
            'user' => $user->load('role', 'role.perms')
        ]);
    }

    public function langTrans()
    {
        $langs = Lang::with('translations')->get();

        return ApiResponse::make('Langs fetched', [
            'data' => $langs
        ]);
    }

    public function dashboard(Request $request)
    {
        $user = user();
        $request = request();

        $workspaceCount = WorkSpace::count();
        $documentCount = WriterDocument::count();
        $characterGenerated = UsedCharacter::sum('character_count');

        if ($request->has('dates') && $request->dates != null && count($request->dates) > 0) {
            $dates = $request->dates;
            $startDate = $dates[0];
            $endDate = $dates[1];
        } else {
            $startDate =  Carbon::now()->subDays(30)->format("Y-m-d");
            $endDate =  Carbon::now()->format("Y-m-d");
        }

        $allCharacters = UsedCharacter::select(DB::raw('date(created_at) as date, sum(character_count) as character_counted'))
            ->whereRaw('DATE(created_at) >= ?', [$startDate])
            ->whereRaw('DATE(created_at) <= ?', [$endDate])
            ->groupByRaw('date(created_at)')
            ->orderByRaw("date(created_at) asc")
            ->pluck('character_counted', 'date');

        $periodDates = CarbonPeriod::create($startDate, $endDate);
        $datesArray = [];
        $characterCount = [];

        // Iterate over the period
        foreach ($periodDates as $periodDate) {
            $currentDate =  $periodDate->format('Y-m-d');

            if (isset($allCharacters[$currentDate])) {
                $datesArray[] = $currentDate;
                $characterCount[] = isset($allCharacters[$currentDate]) ? $allCharacters[$currentDate] : 0;
            }
        }

        $characterHistory = [
            'dates' => $datesArray,
            'characters' => $characterCount,
        ];


        return ApiResponse::make('Data fetched', [
            'stateData' => [
                'workspace_count' => $workspaceCount,
                'document_count' => $documentCount,
                'character_generated' => $characterGenerated,
            ],
            'characterHistory' => $characterHistory
        ]);
    }

    public function changeThemeMode(Request $request)
    {
        $mode = $request->has('theme_mode') ? $request->theme_mode : 'light';

        session(['theme_mode' => $mode]);

        if ($mode == 'dark') {
            $company = company();
            $company->left_sidebar_theme = 'dark';
            $company->save();

            $updatedCompany = company(true);
        }

        return ApiResponse::make('Success', [
            'status' => "success",
            'themeMode' => $mode,
            'themeModee' => session()->all(),
        ]);
    }

    public function getAllTimezones()
    {
        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);

        return ApiResponse::make('Success', [
            'timezones' => $timezones,
            'date_formates' => [
                'd-m-Y' => 'DD-MM-YYYY',
                'm-d-Y' => 'MM-DD-YYYY',
                'Y-m-d' => 'YYYY-MM-DD',
                'd.m.Y' => 'DD.MM.YYYY',
                'm.d.Y' => 'MM.DD.YYYY',
                'Y.m.d' => 'YYYY.MM.DD',
                'd/m/Y' => 'DD/MM/YYYY',
                'm/d/Y' => 'MM/DD/YYYY',
                'Y/m/d' => 'YYYY/MM/DD',
                'd/M/Y' => 'DD/MMM/YYYY',
                'd.M.Y' => 'DD.MMM.YYYY',
                'd-M-Y' => 'DD-MMM-YYYY',
                'd M Y' => 'DD MMM YYYY',
                'd F, Y' => 'DD MMMM, YYYY',
                'D/M/Y' => 'ddd/MMM/YYYY',
                'D.M.Y' => 'ddd.MMM.YYYY',
                'D-M-Y' => 'ddd-MMM-YYYY',
                'D M Y' => 'ddd MMM YYYY',
                'd D M Y' => 'DD ddd MMM YYYY',
                'D d M Y' => 'ddd DD MMM YYYY',
                'dS M Y' => 'Do MMM YYYY',
            ],
            'time_formates' => [
                "hh:mm A" => '12 Hours hh:mm A',
                'hh:mm a' => '12 Hours hh:mm a',
                'hh:mm:ss A' => '12 Hours hh:mm:ss A',
                'hh:mm:ss a' => '12 Hours hh:mm:ss a',
                'HH:mm ' => '24 Hours HH:mm:ss',
                'HH:mm:ss' => '24 Hours hh:mm:ss',
            ]
        ]);
    }
}
