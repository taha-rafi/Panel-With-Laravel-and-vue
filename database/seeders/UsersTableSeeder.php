<?php

namespace Database\Seeders;

use App\Classes\Common;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();
        DB::table('role_user')->delete();

        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE role_user AUTO_INCREMENT = 1');

        $count = env('SEED_RECORD_COUNT', 30);
        $faker = \Faker\Factory::create();

        $company = Company::where('is_global', 0)->first();

        // Admin User
        $adminRole = Role::where('name', 'admin')->first();
        $admin = new User();
        $admin->company_id = $company->id;
        $admin->name = 'Admin';
        $admin->email = 'admin@example.com';
        $admin->password = '12345678';
        $admin->role_id = $adminRole->id;
        $admin->user_type = "staff_members";
        $admin->save();
        $admin->attachRole($adminRole->id);

        $company->admin_id = $admin->id;
        $company->save();

        // StaffMembers
        User::factory()->count((int)$count)->create()->each(function ($user) use ($faker, $adminRole) {

            $roleId = $adminRole->id;

            $user->role_id = $roleId;
            $user->save();

            // Assign Role
            $user->attachRole($roleId);
        });
    }
}
