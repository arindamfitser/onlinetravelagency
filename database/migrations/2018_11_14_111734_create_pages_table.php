<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('pages', function (Blueprint $table) {
		    $table->increments('id');
            $table->string('template');
		    $table->boolean('status');
		    $table->timestamps();
		    
		});

		Schema::create('pages_translations', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('page_id')->unsigned();
		    $table->string('locale')->index();
		    $table->string('page_title');
		    $table->string('page_slug');
		    $table->longText('page_description');
		    $table->unique(['page_id','locale']);
		    $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('pages_translations');
    }
}
