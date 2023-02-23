<?php

use App\Classes\Common;
use App\Models\Lang;
use App\Models\Translation;
use App\SuperAdmin\Models\GlobalCompany;
use App\SuperAdmin\Models\GlobalSettings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('{path}', function ($path = null) {
    if (file_exists(storage_path('installed'))) {

        if ($path) {
            $pathArray = explode('/', $path);

            if (($pathArray[0] && $pathArray[0] == 'admin') || ($pathArray[0] && $pathArray[0] == 'superadmin') || ($pathArray[0] && $pathArray[0] == 'install')) {
                $appName = "Writerifly";
                $appVersion = File::get(public_path() . '/superadmin_version.txt');
                $modulesData = Common::moduleInformations();
                $themeMode = session()->has('theme_mode') ? session('theme_mode') : 'light';
                $company = GlobalCompany::first();
                $appVersion = File::get('superadmin_version.txt');
                $appVersion = preg_replace("/\r|\n/", "", $appVersion);
                $enLang = Lang::where('key', 'en')->first();
                $loadingLangMessageLang = Translation::where('key', 'loading_app_message')
                    ->where('group', 'messages')
                    ->where('lang_id', $enLang->id)
                    ->first();

                return view('welcome', [
                    'appName' => $appName,
                    'appVersion' => preg_replace("/\r|\n/", "", $appVersion),
                    'installedModules' => $modulesData['installed_modules'],
                    'enabledModules' => $modulesData['enabled_modules'],
                    'themeMode' => $themeMode,
                    'company' => $company,
                    'appVersion' => $appVersion,
                    'appEnv' => env('APP_ENV'),
                    'appType' => 'saas',
                    'loadingLangMessageLang' => $loadingLangMessageLang->value,
                ]);
            } else {
                $langKey = front_lang_key();
                $selectedLang = Lang::where('key', $langKey)->first();
                $allLangs = Lang::where('enabled', 1)->get();

                // Front Settings
                $frontSettings = GlobalSettings::where('setting_type', 'website_settings')
                    ->where('name_key', $langKey)
                    ->first();
                $settings = $frontSettings->credentials;
                $frontSetting = (object) $settings;

                // For Breadcrumb
                $showFullHeader = true;
                $breadcrumbTitle = $frontSetting->home_text;

                // Pages
                $footerPagesSetting = GlobalSettings::where('setting_type', 'footer_pages')
                    ->where('name_key', $langKey)
                    ->first();
                $footerPages = $footerPagesSetting->credentials;
                $footerPages = Common::convertToCollection($footerPages);

                // Common Pages SEO details
                $pageSeoDetails = GlobalSettings::where('setting_type', 'website_seo')
                    ->where('name_key', $langKey)
                    ->first();
                $pageSeoDetails = $pageSeoDetails;

                $lang = Lang::where('key', $langKey)->first();
                $frontTranslations = Translation::where('lang_id', $lang->id)
                    ->where('group', 'front_website')
                    ->pluck('value', 'key')
                    ->toArray();
                $frontTranslations = $frontTranslations;

                $seoDetail = (object) [
                    "id" => 'error',
                    "page_key" => 'error-x',
                    "seo_title" => '404 Error',
                    "seo_author" => $frontSetting->app_name,
                    "seo_keywords" => $frontSetting->app_name,
                    "seo_description" => $frontSetting->app_name,
                    "seo_image" => $frontSetting->header_logo,
                    "seo_image_url" => $frontSetting->header_logo_url
                ];

                // Showing 404 page
                return view('front.error-page', [
                    'langKey' => $langKey,
                    'selectedLang' => $selectedLang,
                    'allLangs' => $allLangs,
                    'frontSetting' => $frontSetting,
                    'showFullHeader' => false,
                    'breadcrumbTitle' => 'Page Not Found',
                    'footerPages' => $footerPages,
                    'pageSeoDetails' => $pageSeoDetails,
                    'frontTranslations' => $frontTranslations,
                    'seoDetail' => $seoDetail,
                ]);
            }
        }
    } else {
        return redirect('/install');
    }
})->where('path', '^(?!api.*$).*')->name('main');
