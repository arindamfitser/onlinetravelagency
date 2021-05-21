<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelsTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'hotels_name', 'hotels_slug', 'hotels_desc'];
}
