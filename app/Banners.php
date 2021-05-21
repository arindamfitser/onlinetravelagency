<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'banners_title','banners_description', 'banners_image', 'banners_link'];

    protected $fillable = ['locale', 'banners_title', 'banners_description', 'banners_image', 'banners_link'];
}
