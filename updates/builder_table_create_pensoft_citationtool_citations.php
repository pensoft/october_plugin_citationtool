<?php namespace Pensoft\CitationTool\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePensoftCitationtoolCitations extends Migration
{
    public function up(): void
    {
        Schema::create('pensoft_citationtool_citations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->text('title');
            $table->text('authors');
            $table->date('year');
            $table->string('journal_title')->nullable();
            $table->string('publisher')->nullable();
            $table->string('pages')->nullable();
            $table->string('volume_issue')->nullable();
            $table->string('doi')->nullable();
            $table->string('place')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pensoft_citationtool_citations');
    }
}
