<?php

namespace App\SuperAdmin\Observers;

use App\Classes\Common;
use App\Models\Company;
use App\Models\Role;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyObserver
{

    public function created(Company $company)
    {
        // $company = Common::addCurrencies($company);

        if (!$company->is_global) {
            $company = $this->addAdminRole($company);
            Common::insertInitSettings($company);

            // Adding Default Subscription Plan
            $company =  $this->addInitialSubscriptionPlan($company);
        }
    }

    public function addAdminRole($company)
    {
        // Seeding Data
        $adminRole = new Role();
        $adminRole->company_id = $company->id;
        $adminRole->name = 'admin';
        $adminRole->display_name = 'Admin';
        $adminRole->description = 'Admin is allowed to manage everything of the app.';
        $adminRole->save();

        return $company;
    }

    public function addInitialSubscriptionPlan($company)
    {
        // Adding trial or default plan as initial plan
        if (app_type() == 'saas') {

            $trialPlan = SubscriptionPlan::where('default', 'trial')->first();
            $defaultPlan = SubscriptionPlan::where('default', 'yes')->first();

            // if trial package is active set package to company
            if ($trialPlan && $trialPlan->active == 1) {
                $company->subscription_plan_id = $trialPlan->id;

                // set company license expire date
                $company->licence_expire_on = Carbon::now()->addDays($trialPlan->duration)->format('Y-m-d');

                $company->remaining_character = $trialPlan->max_characters;
                $company->save();

                // Saving Added Character
                DB::table('added_characters')->insert([
                    'company_id' => $company->id,
                    'character_count' => $trialPlan->max_characters,
                    'notes' => 'Added while registration'
                ]);
            }
            // if trial package is not active set default package to company
            else {
                $company->subscription_plan_id = $defaultPlan->id;
                $company->licence_expire_on = null;
                $company->status = 'license_expired';
                $company->save();
            }
        }

        return $company;
    }
}
