<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'countries_name','countries_sortname', 'countries_phonecode'];

    protected $fillable = ['locale', 'countries_name','countries_sortname', 'countries_phonecode'];
    
    function hotels(){
    	$this->hasMany('App\Hotels');
    }
}
