<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmenitiesTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'amenities_name'];
}
