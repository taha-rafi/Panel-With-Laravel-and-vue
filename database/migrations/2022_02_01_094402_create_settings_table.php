<?php

use App\Classes\NotificationSeed;
use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned()->nullable()->default(null);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_global')->default(false);
            $table->string('setting_type');
            $table->string('name');
            $table->string('name_key');
            $table->text('credentials')->nullable()->default(null);
            $table->text('other_data')->nullable()->default(null);
            $table->boolean('status')->default(false);
            $table->boolean('verified')->default(false);
            $table->timestamps();
        });

        if (app_type() == 'non-saas') {
            $company = Company::where('is_global', 0)->first();

            DB::table('settings')->insert([
                [
                    'company_id' => $company->id,
                    'setting_type' => 'storage',
                    'name' => 'Local',
                    'name_key' => 'local',
                    'credentials' => json_encode([]),
                    'status' => 1,
                ],
                [
                    'company_id' => $company->id,
                    'setting_type' => 'storage',
                    'name' => 'AWS',
                    'name_key' => 'aws',
                    'credentials' => json_encode([
                        'driver' => 's3',
                        'key' => '',
                        'secret' => '',
                        'region' => '',
                        'bucket' => '',
                    ]),
                    'status' => 0,
                ],
                [
                    'company_id' => $company->id,
                    'setting_type' => 'email',
                    'name' => 'SMTP',
                    'name_key' => 'smtp',
                    'credentials' => json_encode([
                        'from_name' => '',
                        'from_email' => '',
                        'host' => '',
                        'port' => '',
                        'encryption' => '',
                        'username' => '',
                        'password' => '',
                    ]),
                    'status' => 0,
                ],
                [
                    'company_id' => $company->id,
                    'setting_type' => 'send_mail_settings',
                    'name' => 'Send mail to warehouse',
                    'name_key' => 'warehouse',
                    'credentials' => json_encode([]),
                    'status' => 0,
                ],
                [
                    'company_id' => $company->id,
                    'setting_type' => 'shortcut_menus',
                    'name' => 'Add Menu',
                    'name_key' => 'shortcut_menus',
                    'credentials' => json_encode([
                        'staff_member',
                        'currency',
                        'language',
                        'role',

                    ]),
                    'status' => 1,
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
