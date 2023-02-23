<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\Currency\IndexRequest;
use App\Http\Requests\Api\Currency\StoreRequest;
use App\Http\Requests\Api\Currency\UpdateRequest;
use App\Http\Requests\Api\Currency\DeleteRequest;
use App\Models\Currency;
use Examyou\RestAPI\Exceptions\ApiException;

class CurrencyController extends ApiBaseController
{
    protected $model = Currency::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = StoreRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    protected function modifyIndex($query)
    {
        if (app_type() == 'saas') {
            $company = company();
            $query = $query->withoutGlobalScope(CompanyScope::class)
                ->where('currencies.company_id', $company->id);
        }

        return $query;
    }

    public function storing(Currency $currency)
    {
        if (app_type() == 'saas') {
            $company = company();
            $currency->company_id = $company->id;
        }

        return $currency;
    }

    public function updating(Currency $currency)
    {
        if (app_type() == 'saas') {
            $company = company();
            $currency->company_id = $company->id;
        }

        return $currency;
    }

    public function destroying(Currency $currency)
    {
        $company = company();

        if ($currency->id == $company->currency_id) {
            throw new ApiException('Default currency cannot be deleted');
        }

        return $currency;
    }
}
