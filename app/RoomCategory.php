<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
     protected $fillable = ['name', 'classification_id'];

     function classification(){
    	return $this->belongsTo('App\RoomClassification');
    }
    function rooms(){
    	$this->hasMany('App\Rooms');
    }
}
