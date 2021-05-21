<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccommodationsTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'accommodations_name','accommodations_slug', 'accommodations_image'];
}
