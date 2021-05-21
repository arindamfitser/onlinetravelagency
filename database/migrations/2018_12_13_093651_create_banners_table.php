<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('banners_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('banners_id')->unsigned();
            $table->string('locale')->index();
            $table->string('banners_title');
            $table->string('banners_image');
            $table->string('banners_link');
            $table->text('banners_description');
            $table->unique(['banners_id','locale']);
            $table->foreign('banners_id')->references('id')->on('banners')->onDelete('cascade');
        });

        Schema::table('banners_translations', function (Blueprint $table) {
            $table->string('banners_link')->nullable();
            $table->string('banners_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
