<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'regions_name'];

    protected $fillable = ['locale', 'regions_name']; 

    function hotels(){
    	$this->hasMany('App\Hotels');
    }
}
