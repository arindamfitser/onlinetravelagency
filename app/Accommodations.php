<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accommodations extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'accommodations_name','accommodations_slug', 'accommodations_image'];

    protected $fillable = ['locale', 'accommodations_name','accommodations_slug', 'accommodations_image'];
}
