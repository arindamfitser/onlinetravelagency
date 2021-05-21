<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannersTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'banners_title', 'banners_description', 'banners_image', 'banners_link'];
}
