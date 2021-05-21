<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
   use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale','post_title','post_slug','post_description'];

    protected $fillable = ['locale','post_title','post_slug', 'post_description'];
}
