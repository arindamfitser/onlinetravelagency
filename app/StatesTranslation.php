<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatesTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'states_name','countries_id'];
}
