<?php

namespace Database\Seeders;

use App\Classes\PermsSeed;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Model::unguard();

        DB::table('permissions')->delete();
        DB::table('roles')->delete();

        DB::statement('ALTER TABLE `permissions` AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');

        PermsSeed::seedPermissions();

        $company = Company::where('is_global', 0)->first();

        $adminRole = new Role();
        $adminRole->company_id = $company->id;
        $adminRole->name = 'admin';
        $adminRole->display_name = 'Admin';
        $adminRole->description = 'Admin is allowed to manage everything of the app.';
        $adminRole->save();
    }
}
