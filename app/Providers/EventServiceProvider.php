<?php

namespace App\Providers;

use App\Models\UsedCharacter;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use App\Models\WriterDocument;
use App\Models\WorkSpace;
use App\Observers\UsedCharacterObserver;
use App\Observers\CurrencyObserver;
use App\Observers\RoleObserver;
use App\Observers\SettingObserver;
use App\Observers\UserObserver;
use App\Observers\WriterDocumentObserver;
use App\Observers\WorkSpaceObserver;
use App\SuperAdmin\Models\SuperAdmin;
use App\SuperAdmin\Observers\SuperAdminObserver;
use App\SuperAdmin\Observers\CompanyObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Don't run observer when
        // we run command using
        if (!app()->runningInConsole()) {
            $appType = app_type();

            User::observe(UserObserver::class);
            Settings::observe(SettingObserver::class);
            Currency::observe(CurrencyObserver::class);
            Role::observe(RoleObserver::class);
            WriterDocument::observe(WriterDocumentObserver::class);
            WorkSpace::observe(WorkSpaceObserver::class);
            UsedCharacter::observe(UsedCharacterObserver::class);

            if ($appType == 'saas') {
                Company::observe(CompanyObserver::class);
                SuperAdmin::observe(SuperAdminObserver::class);
            }
        }
    }
}
