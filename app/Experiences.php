<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiences extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'experiences_name', 'experiences_image'];

    protected $fillable = ['locale', 'experiences_name', 'experiences_image']; 
}
