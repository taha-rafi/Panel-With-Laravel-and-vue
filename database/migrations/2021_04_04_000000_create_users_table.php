<?php

use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned()->nullable()->default(null);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('role_id')->unsigned()->nullable()->default(null);
            $table->boolean('is_superadmin')->default(false);
            $table->string('user_type')->default('staff_members');
            $table->boolean('login_enabled')->default(true);
            $table->string('name');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('phone')->nullable()->default(null);
            $table->string('profile_image')->nullable()->default(null);
            $table->string('address', 1000)->nullable()->default(null);
            $table->string('shipping_address', 1000)->nullable()->default(null);
            $table->string('email_verification_code', 50)->nullable()->default(null);

            $table->string('status')->default('enabled');
            $table->string('reset_code')->nullable()->default(null);

            $table->string('timezone', 50)->default('Asia/Kolkata');
            $table->string('date_format', 20)->default('d-m-Y');
            $table->string('date_picker_format', 20)->default('dd-mm-yyyy');
            $table->string('time_format', 20)->default('h:i a');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
