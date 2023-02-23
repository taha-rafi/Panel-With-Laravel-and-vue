<?php

namespace App\Imports;

use App\Models\Lang;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToArray;

class TranslationImport implements ToArray, WithHeadingRow
{
    public function array(array $langs)
    {
        DB::transaction(function () use ($langs) {

            foreach ($langs as $lang) {

                if (
                    !array_key_exists('lang_key', $lang) || !array_key_exists('group', $lang) ||
                    !array_key_exists('key', $lang) || !array_key_exists('value', $lang)
                ) {
                    throw new ApiException('Field missing from header.');
                }

                $langKey = trim($lang['lang_key']);
                $language = Lang::where('key', $langKey)->first();

                if ($language) {
                    DB::table('translations')
                        ->where('key', trim($lang['key']))
                        ->where('group', trim($lang['group']))
                        ->where('lang_id', $language->id)
                        ->update([
                            'value' => trim($lang['value'])
                        ]);
                } else {
                    throw new ApiException('Language not exists... First create it');
                }
            }
        });
    }
}
