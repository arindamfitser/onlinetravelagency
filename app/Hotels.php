<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['locale', 'hotels_name', 'hotels_slug', 'hotels_desc'];

    protected $fillable = ['locale', 'hotels_name', 'hotels_slug', 'hotels_desc'];

    function region(){
    	return $this->belongsTo('App\Regions');
    }

    function country(){
    	return $this->belongsTo('App\Countries');
    }

    function state(){
    	return $this->belongsTo('App\States');
    }
}
