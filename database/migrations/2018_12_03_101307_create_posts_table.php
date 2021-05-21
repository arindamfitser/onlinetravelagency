<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->timestamps();
            
        });

        Schema::create('posts_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('posts_id')->unsigned();
            $table->string('locale')->index();
            $table->string('post_title');
            $table->string('post_slug');
            $table->longText('post_description')->default('NULL');
            $table->unique(['posts_id','locale']);
            $table->foreign('posts_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }
}
