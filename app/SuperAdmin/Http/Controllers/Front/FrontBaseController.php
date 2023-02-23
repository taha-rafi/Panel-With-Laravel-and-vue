<?php

namespace App\SuperAdmin\Http\Controllers\Front;

use App\Classes\Common;
use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Translation;
use App\SuperAdmin\Models\GlobalSettings;

// use App\Models\FrontPage;
// use App\Models\FrontSetting;
// use Illuminate\Support\Facades\App;

class FrontBaseController extends Controller
{
    public $data = [];

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->langKey = front_lang_key();
            $this->selectedLang = Lang::where('key', $this->langKey)->first();
            $this->allLangs = Lang::where('enabled', 1)->get();

            // Front Settings
            $frontSettings = GlobalSettings::where('setting_type', 'website_settings')
                ->where('name_key', $this->langKey)
                ->first();
            $settings = $frontSettings->credentials;
            $this->frontSetting = (object) $settings;

            // For Breadcrumb
            $this->showFullHeader = true;
            $this->breadcrumbTitle = $this->frontSetting->home_text;

            //  Pages
            $footerPagesSetting = GlobalSettings::where('setting_type', 'footer_pages')
                ->where('name_key', $this->langKey)
                ->first();
            $footerPages = $footerPagesSetting->credentials;
            $this->footerPages = Common::convertToCollection($footerPages);

            // Common Pages SEO details
            $pageSeoDetails = GlobalSettings::where('setting_type', 'website_seo')
                ->where('name_key', $this->langKey)
                ->first();
            $this->pageSeoDetails = $pageSeoDetails;

            $lang = Lang::where('key', $this->langKey)->first();
            $frontTranslations = Translation::where('lang_id', $lang->id)
                ->where('group', 'front_website')
                ->pluck('value', 'key')
                ->toArray();
            $this->frontTranslations = $frontTranslations;

            return $next($request);
        });


        // App::setLocale($this->setting->locale);
    }

    public function getPageSeoDetails($pageKey)
    {
        $pageDetails = [];

        foreach ($this->pageSeoDetails['credentials'] as $pageSeoDetail) {
            if ($pageSeoDetail['page_key'] == $pageKey) {
                $pageDetails = (object) $pageSeoDetail;
            }
        }

        return $pageDetails;
    }
}
