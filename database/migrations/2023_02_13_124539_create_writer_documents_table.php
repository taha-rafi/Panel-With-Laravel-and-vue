<?php

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
        Schema::create('writer_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->unsigned()->nullable()->default(null);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('writer_template_id')->unsigned()->nullable()->default(null);
            $table->foreign('writer_template_id')->references('id')->on('writer_templates')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('workspace_id')->unsigned()->nullable()->default(null);
            $table->foreign('workspace_id')->references('id')->on('workspaces')->onDelete('cascade')->onUpdate('cascade');
            $table->string('prompt_text', 1000)->nullable()->default(null);
            $table->string('document_name')->nullable()->default('Untitled Document');
            $table->longText('content');
            $table->bigInteger('word_count')->unsigned()->default(0);
            $table->bigInteger('character_count')->unsigned()->default(0);
            $table->bigInteger('created_by')->unsigned()->nullable()->default(null);
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('writer_documents');
    }
};
