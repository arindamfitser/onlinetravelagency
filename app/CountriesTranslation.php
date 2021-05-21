<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountriesTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'countries_name','countries_sortname', 'countries_phonecode'];
}
