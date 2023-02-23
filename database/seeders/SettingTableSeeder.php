<?php

namespace Database\Seeders;

use App\Classes\Common;
use App\Classes\LangTrans;
use App\Models\Company;
use App\Models\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Model::unguard();
        DB::table('settings')->delete();
        DB::statement('ALTER TABLE settings AUTO_INCREMENT = 1');

        $company = Company::where('is_global', 0)->first();
        Common::insertInitSettings($company);
    }
}
