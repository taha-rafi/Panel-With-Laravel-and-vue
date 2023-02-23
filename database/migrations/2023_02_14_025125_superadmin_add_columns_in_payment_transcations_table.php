<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuperadminAddColumnsInPaymentTranscationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_transcations', function (Blueprint $table) {
            $table->string('plan_type', 20)->nullable()->default(null)->after('total'); // ['monthly', 'annual']
            $table->string('status', 20)->nullable()->default(null)->after('plan_type'); // ['pending', 'approved', 'rejected']
            $table->string('proof_document')->nullable()->default(null)->after('status');
            $table->bigInteger('submitted_by_id')->unsigned()->nullable()->after('proof_document');
            $table->foreign('submitted_by_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->bigInteger('offline_payment_mode_id')->unsigned()->nullable()->default(null)->after('submitted_by_id');
            $table->foreign('offline_payment_mode_id')->references('id')->on('offline_payment_modes')->onDelete('set null')->onUpdate('cascade');
            $table->boolean('is_offline_request')->default(false)->after('offline_payment_mode_id');
            $table->text('submit_description')->nullable()->default(null)->after('is_offline_request');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->bigInteger('payment_transcation_id')->unsigned()->nullable()->after('licence_expire_on');
            $table->foreign('payment_transcation_id')->references('id')->on('payment_transcations')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_transcations', function (Blueprint $table) {
            $table->dropColumn('plan_type');
            $table->dropColumn('status');
            $table->dropColumn('proof_document');
            $table->dropForeign('payment_transcations_submitted_by_id_foreign');
            $table->dropColumn('submitted_by_id');
            $table->dropForeign('payment_transcations_offline_payment_mode_id_foreign');
            $table->dropColumn('offline_payment_mode_id');
            $table->dropColumn('is_offline_request');
            $table->dropColumn('submit_description');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_payment_transcation_id_foreign');
            $table->dropColumn('payment_transcation_id');
        });
    }
}
