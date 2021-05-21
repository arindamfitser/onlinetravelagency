<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('experiences_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('experiences_id')->unsigned();
            $table->string('locale')->index();
            $table->string('experiences_name');
            $table->unique(['experiences_id','locale']);
            $table->foreign('experiences_id')->references('id')->on('experiences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experience');
        Schema::dropIfExists('experiences_translations');
    }
}
