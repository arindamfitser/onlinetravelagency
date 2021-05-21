<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspirationsTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'inspirations_name', 'inspirations_image'];
}
