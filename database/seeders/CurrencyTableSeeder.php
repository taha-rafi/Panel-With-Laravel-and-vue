<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Model::unguard();

        DB::table('currencies')->delete();

        DB::statement('ALTER TABLE currencies AUTO_INCREMENT = 1');

        $company = Company::where('is_global', 0)->first();

        $usdCurrency = new Currency();
        $usdCurrency->company_id = $company->id;
        $usdCurrency->name = 'Dollar';
        $usdCurrency->code = 'USD';
        $usdCurrency->symbol = '$';
        $usdCurrency->position = 'front';
        $usdCurrency->is_deletable = false;
        $usdCurrency->save();

        $rupeeCurrency = new Currency();
        $rupeeCurrency->company_id = $company->id;
        $rupeeCurrency->name = 'Rupee';
        $rupeeCurrency->code = 'INR';
        $rupeeCurrency->symbol = '₹';
        $rupeeCurrency->position = 'front';
        $rupeeCurrency->is_deletable = false;
        $rupeeCurrency->save();

        $company->currency_id = $usdCurrency->id;
        $company->save();
    }
}
