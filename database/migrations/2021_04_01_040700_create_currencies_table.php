<?php

use App\Models\Company;
use App\Models\Lang;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned()->nullable()->default(null);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('code');
            $table->string('symbol');
            $table->string('position');
            $table->boolean('is_deletable')->default(true);
            $table->timestamps();
        });

        // Creating only for non-saas
        if (app_type() == 'non-saas') {

            $company = Company::where('is_global', 0)->first();

            $currencyId = DB::table('currencies')->insertGetId([
                'company_id' => $company->id,
                'name' => 'Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'position' => 'front',
                'is_deletable' => false,
            ]);

            $company->currency_id = $currencyId;
            $company->save();

            DB::table('currencies')->insert([
                [
                    'company_id' => $company->id,
                    'name' => 'Rupee',
                    'code' => 'INR',
                    'symbol' => '₹',
                    'position' => 'front',
                    'is_deletable' => false,
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
        Schema::dropIfExists('currencies');
    }
}
