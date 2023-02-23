<?php

namespace Database\Seeders;

use App\Classes\LangTrans;
use App\Models\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LangTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run()
	{
		Model::unguard();

		DB::table('langs')->delete();

		DB::statement('ALTER TABLE langs AUTO_INCREMENT = 1');

		$enLang = new Lang();
		$enLang->name = 'English';
		$enLang->key = 'en';
		$enLang->save();

		LangTrans::seedTranslations();
	}
}
