<?php

namespace App\Http\Controllers\Api\Common;

use App\Classes\LangTrans;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\Lang\IndexRequest;
use App\Http\Requests\Api\Lang\StoreRequest;
use App\Http\Requests\Api\Lang\UpdateRequest;
use App\Http\Requests\Api\Lang\DeleteRequest;
use App\Models\Company;
use App\Models\Lang;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use App\Exports\LangExport;
use Maatwebsite\Excel\Excel;

class LangsController extends ApiBaseController
{
    protected $model = Lang::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function stored(Lang $lang)
    {
        LangTrans::seedAllModulesTranslations();

        if (app_type() == 'saas') {
            \App\SuperAdmin\Classes\SuperAdminCommon::createWebsiteSetting($lang->key);
        }
    }

    public function updated(Lang $lang)
    {
        LangTrans::seedAllModulesTranslations();
    }

    public function updating(Lang $lang)
    {
        if ($lang->key == 'en') {
            throw new ApiException('English language cannot be edited');
        }

        return $lang;
    }

    public function destroying(Lang $lang)
    {
        if ($lang->key == 'en') {
            throw new ApiException('English language cannot be deleted');
        }

        if (app_type() == 'saas') {
            // Changing all langs which have
            // this lang id as default
            $allComapaniesHavingThisLang = Company::where('lang_id', $lang->id)->get();
            foreach ($allComapaniesHavingThisLang as $allCompanies) {
                if ($lang->id == $allCompanies->lang_id) {
                    $enLang = Lang::where('key', 'en')->first();
                    $allCompanies->lang_id = $enLang->id;
                    $allCompanies->save();
                }
            }

            // Deleting all Landing website settings
            DB::table('settings')->where('is_global', 1)
                ->where('name_key', $lang->key)->delete();
        }

        // Updating current company language
        $company = company();
        if ($lang->id == $company->lang_id) {
            $enLang = Lang::where('key', 'en')->first();
            $company->lang_id = $enLang->id;
            $company->save();

            $updatedCompany = company(true);
        }

        return $lang;
    }

    public function downloadLang($langXId)
    {
        $langId = $this->getIdFromHash($langXId);
        $lang = Lang::find($langId);

        if ($lang) {
            return (new LangExport($lang))->download($lang->key . '_lang.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        }
    }
}
