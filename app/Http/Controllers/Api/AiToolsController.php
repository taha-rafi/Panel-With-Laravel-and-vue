<?php

namespace App\Http\Controllers\Api;

use App\Classes\Common;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\Writer\WriterRequest;
use App\Models\AddedCharacter;
use App\Models\UsedCharacter;
use App\Models\WriterCategory;
use App\Models\WriterDocument;
use App\Models\WriterTemplate;
use Examyou\RestAPI\ApiResponse;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Support\Str;
use OpenAI;

class AiToolsController extends ApiBaseController
{

    public function getTemplate($xTemplateId)
    {
        $request = request();
        $templateId = $this->getIdFromHash($xTemplateId);

        $writerTemplate = WriterTemplate::with('category')->where('id', $templateId)->first();

        $allTemplates = WriterTemplate::with('category')->where('writer_category_id', $writerTemplate->writer_category_id)
            ->where('status', 1)
            ->get();

        return ApiResponse::make('Success', [
            'template' => $writerTemplate,
            'all_templates' => $allTemplates
        ]);
    }

    public function getAiCategory($categoryId)
    {
        $categoryId = $this->getIdFromHash($categoryId);

        $writerCategory = WriterCategory::where('id', $categoryId)->first();

        $allTemplates = WriterTemplate::where('writer_category_id', $writerCategory->id)
            ->where('status', 1)
            ->get();

        return ApiResponse::make('Success', [
            'category' => $writerCategory,
            'all_templates' => $allTemplates
        ]);
    }

    public function remainingCharacters()
    {
        $remaingCharacter = Common::getRemainingCharacters();

        return ApiResponse::make('Success', [
            'remaining_characters' => $remaingCharacter
        ]);
    }

    public function write(WriterRequest $request)
    {
        $user = user();
        $company = company();
        $request = request();
        $templateId = $this->getIdFromHash($request->template_id);
        $allFields = $request->form_fields;
        $language = $request->has('language') && $request->language != '' ? $request->language : 'english';

        $writerTemplate = WriterTemplate::where('id', $templateId)->first();
        $templateContent = $writerTemplate->prompt_text;

        foreach ($allFields as $allField) {
            $templateContent = str_replace('##' . $allField['name'] . '##', $allField['value'], $templateContent);
        }

        $maxToken = $request->has('max_result_length') && $request->max_result_length > 10 ? $request->max_result_length * 4 : 800;
        $temperature = $request->has('content_quality') ? $request->content_quality : 0.5;

        if ($company && $company->remaining_character > 0) {
            $client = OpenAI::client(env('OPENAI_API_KEY'));

            // '<|language=hindi|> ' . $templateContent
            $result = $client->completions()->create([
                'model' => "text-davinci-003",
                'prompt' =>  '<|language=' . $language . '|> ' . $templateContent,
                'temperature' => $temperature,
                'max_tokens' => $maxToken,
            ]);

            $outputText = "";
            if ($result && $result['choices'] && $result['choices'][0] && $result['choices'][0]['text']) {
                $outputText =  trim($result['choices'][0]['text']);
                $totalChar = Str::length($outputText);
                $wordCount = Str::wordCount($outputText);

                $writerDocument = new WriterDocument();
                $writerDocument->document_name = 'Untitled Document';
                $writerDocument->writer_template_id = $writerTemplate->id;
                $writerDocument->prompt_text = $templateContent;
                $writerDocument->content = $outputText;
                $writerDocument->word_count = $wordCount;
                $writerDocument->character_count = $totalChar;
                $writerDocument->created_by = $user->id;
                $writerDocument->save();

                // Saving Character Counts
                $usedCharacter = new UsedCharacter();
                $usedCharacter->created_by = $user->id;
                $usedCharacter->writer_document_id = $writerDocument->id;
                $usedCharacter->character_count = $totalChar;
                $usedCharacter->word_count = $wordCount;
                $usedCharacter->save();
            }

            $remaingCharacterCount = Common::getRemainingCharacters();
        } else {
            throw new ApiException('Your have no more characters');
        }

        return ApiResponse::make('Success', [
            'document_name' => $writerDocument->document_name,
            'content' => $outputText,
            'workspace_id' => $writerDocument->x_workspace_id,
            'xid' => $writerDocument->xid,
            'remaining_character' => $remaingCharacterCount
        ]);
    }
}
