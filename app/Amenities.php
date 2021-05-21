<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'amenities_name'];

    protected $fillable = ['locale', 'amenities_name'];
}
