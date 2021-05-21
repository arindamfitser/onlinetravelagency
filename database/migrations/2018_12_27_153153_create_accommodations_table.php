<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('accommodations_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodations_id')->unsigned();
            $table->string('locale')->index();
            $table->string('accommodations_name');
            $table->string('accommodations_slug');
            $table->unique(['accommodations_id','locale']);
            $table->foreign('accommodations_id')->references('id')->on('accommodations')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodations');
        Schema::dropIfExists('accommodations_translations');
    }
}
