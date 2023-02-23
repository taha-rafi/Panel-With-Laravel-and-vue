<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuperadminCreatePaymentTranscationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transcations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_method');
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('subscription_plan_id')->unsigned();
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('paid_on')->nullable()->default(null);
            $table->date('next_payment_date')->nullable()->default(null);
            $table->string('subscription_id')->nullable()->default(null);
            $table->string('invoice_id')->nullable()->default(null);
            $table->string('transcation_id')->nullable()->default(null);
            $table->float('total', 8, 2)->nullable()->default(0);
            $table->text('response_data')->nullable()->default(null);
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
        Schema::dropIfExists('payment_transcations');
    }
}
