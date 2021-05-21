<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperiencesTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'experiences_name', 'experiences_image'];
}
