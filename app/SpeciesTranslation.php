<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpeciesTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'species_name', 'species_image'];
}
