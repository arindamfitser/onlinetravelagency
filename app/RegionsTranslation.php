<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionsTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'regions_name'];
}
