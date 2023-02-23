<?php

use App\Classes\Common;
use App\Models\WriterCategory;
use App\Models\WriterTemplate;
use App\SuperAdmin\Classes\SuperAdminCommon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('writer_templates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('writer_category_id')->unsigned()->nullable()->default(null);
            $table->foreign('writer_category_id')->references('id')->on('writer_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('logo')->nullable()->default(null);
            $table->text('description');
            $table->boolean('status')->default(true);
            $table->longText('form_fields');
            $table->longText('prompt_text');
            $table->bigInteger('created_by')->unsigned()->nullable()->default(null);
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('updated_by')->unsigned()->nullable()->default(null);
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        $allTools = SuperAdminCommon::aiToolsData();

        foreach ($allTools as $allBlog) {
            $writerCategory = new WriterCategory();
            $writerCategory->name = $allBlog['name'];
            $writerCategory->description = $allBlog['description'];
            $writerCategory->save();

            $allWriterTempaltes = $allBlog['templates'];

            foreach ($allWriterTempaltes as $allWriterTempalte) {
                $writerTempalte = new WriterTemplate();
                $writerTempalte->writer_category_id = $writerCategory->id;
                $writerTempalte->name = $allWriterTempalte['name'];
                $writerTempalte->description = $allWriterTempalte['description'];
                $writerTempalte->form_fields = $allWriterTempalte['form_fields'];
                $writerTempalte->prompt_text = $allWriterTempalte['prompt_text'];
                $writerTempalte->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('writer_templates');
    }
};
