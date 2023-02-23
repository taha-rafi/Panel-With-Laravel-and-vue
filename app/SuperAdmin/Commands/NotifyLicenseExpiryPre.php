<?php

namespace App\SuperAdmin\Commands;

use App\Models\Company;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPlanSetting;
use App\Notifications\LicenseExpire;
use App\Notifications\LicenseExpirePre;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class NotifyLicenseExpiryPre extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify-license-expiry-pre';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notificaiton Pre Expiry Date';

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
        // TODO - send notificaiton number of days before till licence_expire_on date plans going to expire
        // notification will be send
        // number of days before (to) => licence_expire_on date (from)

        // $trialPlan = SubscriptionPlan::where('default', 'trial')->first();
        // if (!is_null($trialPlan->notify_before)) {
        //     $companiesNotify = Company::select('id', 'admin_id', 'licence_expire_on')
        //         ->where('status', 'active')
        //         ->whereNotNull('licence_expire_on')
        //         // ->whereRaw('DATE(companies.licence_expire_on) = ?', [Carbon::now()->addDays($trialPlan->notify_before)->format('Y-m-d')])
        //         ->get();

        //     foreach ($companiesNotify as $cmp) {
        //         $companyUser = User::join('role_user', 'role_user.user_id', '=', 'users.id')
        //             ->join('roles', 'roles.id', '=', 'role_user.role_id')
        //             ->where('users.company_id', $cmp->id)
        //             ->where('roles.name', 'admin')->first();
        //         if ($companyUser->email) {
        //             $companyUser->notify(new LicenseExpirePre(($companyUser)));
        //         }
        //     }
        // }
    }
}
