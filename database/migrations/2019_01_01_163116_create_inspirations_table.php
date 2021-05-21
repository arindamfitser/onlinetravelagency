<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspirationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspirations', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('inspirations_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inspirations_id')->unsigned();
            $table->string('locale')->index();
            $table->string('inspirations_name');
            $table->unique(['inspirations_id','locale']);
            $table->foreign('inspirations_id')->references('id')->on('inspirations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspirations');
        Schema::dropIfExists('inspirations_translations');
    }
}
