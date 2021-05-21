<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

         Schema::create('testimonials_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('testimonials_id')->unsigned();
            $table->string('locale')->index();
            $table->string('testimonials_name');
            $table->string('testimonials_image')->nullable($value = true);
            $table->text('testimonials_content');
            $table->unique(['testimonials_id','locale']);
            $table->foreign('testimonials_id')->references('id')->on('testimonials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
}
