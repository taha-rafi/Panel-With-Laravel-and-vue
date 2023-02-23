<?php

namespace App\Classes;

use App\Models\AddedCharacter;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Lang;
use App\Models\Settings;
use App\Models\SubscriptionPlan;
use App\Models\UsedCharacter;
use App\Models\User;
use App\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Vinkla\Hashids\Facades\Hashids;

class Common
{
    public static function getFolderPath($type = null)
    {
        $paths = [
            'companyLogoPath' => 'companies',
            'userImagePath' => 'users',
            'langImagePath' => 'langs',
            'templateImagePath' => 'templates',
            'categoryImagePath' => 'categories',
            'frontBannerPath' => 'banners',
            'websiteImagePath' => 'website',
            'offlineRequestDocumentPath' => 'offline-requests',
        ];

        return ($type == null) ? $paths : $paths[$type];
    }

    public static function uploadFile($request)
    {
        $folder = $request->folder;
        $folderString = "";

        if ($folder == "user") {
            $folderString = "userImagePath";
        } else if ($folder == "company") {
            $folderString = "companyLogoPath";
        } else if ($folder == "langs") {
            $folderString = "langImagePath";
        } else if ($folder == "categories") {
            $folderString = "categoryImagePath";
        } else if ($folder == "templates") {
            $folderString = "templateImagePath";
        } else if ($folder == "banners") {
            $folderString = "frontBannerPath";
        } else if ($folder == "website") {
            $folderString = "websiteImagePath";
        } else if ($folder == "offline-requests") {
            $folderString = "offlineRequestDocumentPath";
        }

        $folderPath = self::getFolderPath($folderString);

        if ($request->hasFile('image') || $request->hasFile('file')) {
            $largeLogo  = $request->hasFile('image') ? $request->file('image') : $request->file('file');

            $fileName   = $folder . '_' . strtolower(Str::random(20)) . '.' . $largeLogo->getClientOriginalExtension();
            $largeLogo->storePubliclyAs($folderPath, $fileName);
        }

        return [
            'file' => $fileName,
            'file_url' => self::getFileUrl($folderPath, $fileName),
        ];
    }

    public static function checkFileExists($folderString, $fileName)
    {
        $folderPath = self::getFolderPath($folderString);

        $fullPath = $folderPath . '/' . $fileName;

        return Storage::exists($fullPath);
    }

    public static function getFileUrl($folderPath, $fileName)
    {
        if (config('filesystems.default') == 's3') {
            $path = $folderPath . '/' . $fileName;

            return Storage::url($path);
        } else {
            $path =  'uploads/' . $folderPath . '/' . $fileName;

            return asset($path);
        }
    }

    public static function moduleInformations()
    {
        $allModules = Module::all();
        $allEnabledModules = Module::allEnabled();
        $installedModules = [];
        $enabledModules = [];

        foreach ($allModules as $key => $allModule) {
            $modulePath = $allModule->getPath();
            $versionFileName = app_type() == 'saas' ? 'superadmin_version.txt' : 'version.txt';
            $version = File::get($modulePath . '/' . $versionFileName);

            $installedModules[] = [
                'verified_name' => $key,
                'current_version' => preg_replace("/\r|\n/", "", $version)
            ];
        }

        foreach ($allEnabledModules as $allEnabledModuleKey => $allEnabledModule) {
            $enabledModules[] = $allEnabledModuleKey;
        }

        return [
            'installed_modules' => $installedModules,
            'enabled_modules' => $enabledModules,
        ];
    }

    public static function getIdFromHash($hash)
    {
        if ($hash != "") {
            $convertedId = Hashids::decode($hash);
            $id = $convertedId[0];

            return $id;
        }

        return $hash;
    }

    public static function getHashFromId($id)
    {
        $id = Hashids::encode($id);

        return $id;
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function addWebsiteImageUrl($settingData, $keyName)
    {
        if ($settingData && array_key_exists($keyName, $settingData)) {
            if ($settingData[$keyName] != '') {
                $imagePath = self::getFolderPath('websiteImagePath');

                $settingData[$keyName . '_url'] = Common::getFileUrl($imagePath, $settingData[$keyName]);
            } else {
                $settingData[$keyName] = null;
                $settingData[$keyName . '_url'] = asset('images/website.png');
            }
        }

        return $settingData;
    }

    public static function calculateTotalUsers($companyId, $update = false)
    {
        $totalUsers =  User::withoutGlobalScope(CompanyScope::class)
            ->where('company_id', $companyId)
            ->count('id');

        if ($update) {
            DB::table('companies')
                ->where('id', $companyId)
                ->update([
                    'total_users' => $totalUsers
                ]);
        }


        return $totalUsers;
    }

    public static function convertToCollection($data)
    {
        $data = collect($data)->map(function ($item) {
            return (object) $item;
        });

        return $data;
    }

    public static function addCurrencies($company)
    {
        $newCurrency = new Currency();
        $newCurrency->company_id = $company->id;
        $newCurrency->name = 'Dollar';
        $newCurrency->code = 'USD';
        $newCurrency->symbol = '$';
        $newCurrency->position = 'front';
        $newCurrency->is_deletable = false;
        $newCurrency->save();

        $rupeeCurrency = new Currency();
        $rupeeCurrency->company_id = $company->id;
        $rupeeCurrency->name = 'Rupee';
        $rupeeCurrency->code = 'INR';
        $rupeeCurrency->symbol = '₹';
        $rupeeCurrency->position = 'front';
        $rupeeCurrency->is_deletable = false;
        $rupeeCurrency->save();

        $enLang = Lang::where('key', 'en')->first();

        $company->currency_id = $newCurrency->id;
        $company->lang_id = $enLang->id;
        $company->save();

        return $company;
    }

    public static function checkSubscriptionModuleVisibility($itemType)
    {
        $visible = true;

        if (app_type() == 'saas') {
            if ($itemType == 'user') {
                $userCounts = User::count();
                $company = company();

                $visible = $company && $company->subscriptionPlan && $userCounts < $company->subscriptionPlan->max_products ? true : false;
            }
        }

        return $visible;
    }

    public static function allVisibleSubscriptionModules()
    {
        $visibleSubscriptionModules = [];

        if (self::checkSubscriptionModuleVisibility('user')) {
            $visibleSubscriptionModules[] = 'user';
        }

        return $visibleSubscriptionModules;
    }

    public static function insertInitSettings($company)
    {
        if (app_type() == 'saas' && $company->is_global == 1) {
            $storageLocalSettingCount = Settings::withoutGlobalScope(CompanyScope::class)
                ->where('setting_type', 'storage')
                ->where('name_key', 'local')
                ->where('is_global', $company->is_global)
                ->where('company_id', $company->id)
                ->count();
            if ($storageLocalSettingCount == 0) {
                $local = new Settings();
                $local->company_id = $company->id;
                $local->setting_type = 'storage';
                $local->name = 'Local';
                $local->name_key = 'local';
                $local->status = true;
                $local->is_global = $company->is_global;
                $local->save();
            }

            $storageAwsSettingCount = Settings::withoutGlobalScope(CompanyScope::class)
                ->where('setting_type', 'storage')
                ->where('name_key', 'aws')
                ->where('is_global', $company->is_global)
                ->where('company_id', $company->id)
                ->count();
            if ($storageAwsSettingCount == 0) {
                $aws = new Settings();
                $aws->company_id = $company->id;
                $aws->setting_type = 'storage';
                $aws->name = 'AWS';
                $aws->name_key = 'aws';
                $aws->credentials = [
                    'driver' => 's3',
                    'key' => '',
                    'secret' => '',
                    'region' => '',
                    'bucket' => '',

                ];
                $aws->is_global = $company->is_global;
                $aws->save();
            }

            $smtpEmailSettingCount = Settings::withoutGlobalScope(CompanyScope::class)
                ->where('setting_type', 'email')
                ->where('name_key', 'smtp')
                ->where('is_global', $company->is_global)
                ->where('company_id', $company->id)
                ->count();
            if ($smtpEmailSettingCount == 0) {
                $smtp = new Settings();
                $smtp->company_id = $company->id;
                $smtp->setting_type = 'email';
                $smtp->name = 'SMTP';
                $smtp->name_key = 'smtp';
                $smtp->credentials = [
                    'from_name' => '',
                    'from_email' => '',
                    'host' => '',
                    'port' => '',
                    'encryption' => '',
                    'username' => '',
                    'password' => '',

                ];
                $smtp->is_global = $company->is_global;
                $smtp->save();
            }
        }
    }

    public static function assignCompanyForNonSaas($company)
    {
        $adminUser = User::first();
        $company->admin_id = $adminUser->id;
        // Setting Trial Plan
        if (app_type() == 'saas') {
            $trialPlan = SubscriptionPlan::where('default', 'trial')->first();
            if ($trialPlan) {
                $company->subscription_plan_id = $trialPlan->id;
                // set company license expire date
                $company->licence_expire_on = Carbon::now()->addDays($trialPlan->duration)->format('Y-m-d');
            }
        }
        $company->save();

        // Insert records in settings table
        // For inital settings like email, storage
        Common::insertInitSettings($company);
    }

    public static function getRemainingCharacters()
    {
        $user = auth('api')->user();
        $remaingCharacterCount = 0;

        if ($user && !$user->is_superadmin) {
            $company = Company::find($user->company_id);

            $usedCharacterCount = UsedCharacter::sum('character_count');
            $addedCharacterCount = AddedCharacter::sum('character_count');
            $remaingCharacterCount = $addedCharacterCount > $usedCharacterCount ? ($addedCharacterCount - $usedCharacterCount) : 0;
            $company = company();

            $company->remaining_character = $remaingCharacterCount;
            $company->save();
        }

        return $remaingCharacterCount;
    }
}
