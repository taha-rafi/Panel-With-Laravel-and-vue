<?php

namespace App\SuperAdmin\Commands;

use App\Models\Company;
use App\Models\StaffMember;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\SuperAdmin\Notifications\LicenseExpire;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class UpdateLicenseExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-licence-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set status for licence expire of all companies in companies table.';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // licence_expire_on is null => means current plan is default plan
        $companies = Company::with('subscriptionPlan')
            ->where('status', 'active')
            ->whereNotNull('licence_expire_on')
            ->whereRaw('DATE(companies.licence_expire_on) < ?', [Carbon::now()->format('Y-m-d')])
            ->get();

        $defaultPlan = SubscriptionPlan::where('default', 'yes')->first();

        // Set default package for license expired companies.
        if ($companies) {
            foreach ($companies as $company) {
                $licenceExpireOn = $company->licence_expire_on;
                $currentPackage = $company->subscriptionPlan;

                if ($currentPackage->default == 'trial' && $defaultPlan) {
                    $company->subscription_plan_id = $defaultPlan->id;
                    $company->licence_expire_on = null;
                } else {
                    $company->licence_expire_on = null;
                }
                $company->status = 'license_expired';
                $company->save();

                if ($company->company_email) {
                    $companyAdmin = User::select('email')->where('id', $company->admin_id)->first();

                    if ($companyAdmin && !is_null($licenceExpireOn)) {
                        $notficationData = [
                            'expiry_date' => $licenceExpireOn,
                        ];
                        Notification::route('mail', $companyAdmin->email)->notify(new LicenseExpire($notficationData));
                    }
                }
            }
        }
    }
}
