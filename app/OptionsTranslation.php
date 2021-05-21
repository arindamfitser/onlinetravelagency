<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionsTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'options_value'];
}
