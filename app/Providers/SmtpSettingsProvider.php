<?php

namespace App\Providers;

use App\Classes\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class SmtpSettingsProvider extends ServiceProvider
{

    public function register()
    {
        try {
            $mailSetting = DB::table('settings')->where('setting_type', 'email')->where('status', 1)->where('verified', 1);

            if (app_type() == 'saas') {
                $mailSetting = $mailSetting->where('is_global', 1);
            } else {
                $mailSetting = $mailSetting->where('is_global', 0);
            }

            $mailSetting =  $mailSetting->first();

            // Company
            $company = DB::table('companies');
            if (app_type() == 'saas') {
                $company = $company->where('is_global', 1);
            }
            $company = $company->first();

            // Mail Setting
            $mailSetting = DB::table('settings')->where('setting_type', 'email')->where('status', 1)->where('verified', 1);
            if (app_type() == 'saas') {
                $mailSetting = $mailSetting->where('is_global', 1);
            }
            $mailSetting = $mailSetting->where('company_id', $company->id)->first();

            $companyLogoPath = Common::getFolderPath('companyLogoPath');

            $lightLogo = $company->light_logo == null ? asset('images/light.png') : Common::getFileUrl($companyLogoPath, $company->light_logo);
            $darkLogo = $company->dark_logo == null ? asset('images/dark.png') : Common::getFileUrl($companyLogoPath, $company->dark_logo);

            config([
                'app.name' => $company->short_name,
                'app.dark_logo' => $darkLogo,
                'app.light_logo' => $lightLogo,
                'app.debug' => $company->app_debug,
                'app.url' => url('/'),
            ]);

            if ($mailSetting) {
                $newMailSetting = json_decode($mailSetting->credentials);
                if (\config('app.env') !== 'development' && $mailSetting->name_key == 'smtp') {
                    config([
                        'mail.default' => $mailSetting->name_key,
                        'mail.mailers.smtp.host' => $newMailSetting->host,
                        'mail.mailers.smtp.port' => $newMailSetting->port,
                        'mail.mailers.smtp.username' => $newMailSetting->username,
                        'mail.mailers.smtp.password' => $newMailSetting->password,
                        'mail.mailers.smtp.encryption' => $newMailSetting->encryption,
                    ]);

                    if ($newMailSetting->enable_mail_queue == 'yes') {
                        config([
                            'queue.default' => 'database',
                        ]);
                    }
                }

                config([
                    'mail.from.name' => $newMailSetting->from_name,
                    'mail.from.address' => $newMailSetting->from_email
                ]);
            }
        } catch (\Exception $e) {
            Log::info($e);
        }
    }

    public function boot()
    {
        //
    }
}
