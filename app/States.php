<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'states_name','countries_id'];

    protected $fillable = ['locale', 'states_name','countries_id'];

    function hotels(){
    	$this->hasMany('App\Hotels');
    }
}
