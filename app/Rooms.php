<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    function categories(){
    	return $this->belongsTo('App\RoomCategory');
    }
}
