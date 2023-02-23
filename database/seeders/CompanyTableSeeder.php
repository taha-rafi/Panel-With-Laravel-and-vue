<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Model::unguard();

        DB::table('companies')->delete();

        DB::statement('ALTER TABLE companies AUTO_INCREMENT = 1');

        $faker = \Faker\Factory::create();

        $enLang = Lang::where('key', 'en')->first();

        $adminCompany = new Company();
        $adminCompany->name = 'Writerifly';
        $adminCompany->short_name = 'Writerifly';
        $adminCompany->email = 'company@example.com';
        $adminCompany->phone = $faker->e164PhoneNumber();
        $adminCompany->address = '7 street, city, state, 762782';
        $adminCompany->lang_id = $enLang->id;
        $adminCompany->save();
    }
}
