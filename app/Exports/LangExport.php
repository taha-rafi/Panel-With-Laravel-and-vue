<?php

namespace App\Exports;

use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LangExport implements FromCollection,  WithHeadings
{
    use Exportable;

    private $lang;

    public function __construct($langDetails)
    {
        $this->lang = $langDetails;
    }

    public function headings(): array
    {
        return [
            'lang_key',
            'group',
            'key',
            'value',
        ];
    }

    public function collection()
    {
        return Translation::join('langs', 'langs.id', '=', 'translations.lang_id')
            ->select(DB::raw('langs.key as lang_key'), 'translations.group', 'translations.key', 'translations.value')
            ->where('lang_id', $this->lang->id)
            ->get();
    }
}
