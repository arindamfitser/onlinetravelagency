<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'options_value'];

    protected $fillable = ['locale', 'options_value'];
}
