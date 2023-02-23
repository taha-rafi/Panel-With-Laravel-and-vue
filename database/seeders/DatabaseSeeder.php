<?php

namespace Database\Seeders;

use App\Classes\Common;
use App\Classes\LangTrans;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') != 'envato') {
            $this->call(LangTableSeeder::class);
            $this->call(CompanyTableSeeder::class);
            $this->call(CurrencyTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(UsersTableSeeder::class);
            $this->call(SettingTableSeeder::class);
        }
    }
}
