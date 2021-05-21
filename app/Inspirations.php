<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspirations extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'inspirations_name', 'inspirations_image'];

    protected $fillable = ['locale', 'inspirations_name', 'inspirations_image'];
}
