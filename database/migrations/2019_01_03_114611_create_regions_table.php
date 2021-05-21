<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::create('regions_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('regions_id')->unsigned();
            $table->string('locale')->index();
            $table->string('regions_name');
            $table->unique(['regions_id','locale']);
            $table->foreign('regions_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
        Schema::dropIfExists('regions_translations');
    }
}
