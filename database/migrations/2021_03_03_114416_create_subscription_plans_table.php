<?php

use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('description', 1000)->nullable();
            $table->double('annual_price')->default(0);
            $table->double('monthly_price')->default(0);
            $table->integer('max_characters')->unsigned()->default(0);
            $table->text('modules')->nullable()->default(null);
            $table->string('default', 20)->default('no'); // 'yes', 'no', 'trial'
            $table->boolean('is_popular')->default(0);
            $table->boolean('is_private')->default(0);
            $table->tinyInteger('billing_cycle')->nullable()->default(null);

            $table->string('stripe_monthly_plan_id')->nullable()->default(null);
            $table->string('stripe_annual_plan_id')->nullable()->default(null);
            $table->string('razorpay_monthly_plan_id')->nullable()->default(null);
            $table->string('razorpay_annual_plan_id')->nullable()->default(null);
            $table->string('paystack_monthly_plan_id')->nullable();
            $table->string('paystack_annual_plan_id')->nullable();

            $table->boolean('active')->default(1);
            $table->integer('duration')->nullable()->default(30);
            $table->integer('notify_before')->nullable()->default(null);
            $table->smallInteger('position')->nullable()->default(null);
            $table->text('features')->nullable()->default(null);
            $table->string('currency_code')->nullable()->default('USD');
            $table->string('currency_symbol')->nullable()->default('$');
            $table->timestamps();
        });

        $defaultPlan = new SubscriptionPlan();
        $defaultPlan->name                    = 'Default';
        $defaultPlan->description             = 'Its a default package and cannot be deleted';
        $defaultPlan->annual_price            = 0;
        $defaultPlan->monthly_price           = 0;
        $defaultPlan->max_characters          = 0;
        $defaultPlan->stripe_annual_plan_id   = 'default_plan';
        $defaultPlan->stripe_monthly_plan_id  = 'default_plan';
        $defaultPlan->default                 = 'yes';
        $defaultPlan->modules = [];
        $defaultPlan->features = [];
        $defaultPlan->save();

        // Trail Subscription Plan
        $trailPlan = new SubscriptionPlan();
        $trailPlan->name                  = 'Trail';
        $trailPlan->description             = 'Its a trial package';
        $trailPlan->annual_price            = 0;
        $trailPlan->monthly_price           = 0;
        $trailPlan->max_characters          = 800;
        $trailPlan->stripe_annual_plan_id   = 'trial_plan';
        $trailPlan->stripe_monthly_plan_id  = 'trial_plan';
        $trailPlan->default                 = 'trial';
        $trailPlan->modules = [];
        $defaultPlan->features = [];
        $trailPlan->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
}
