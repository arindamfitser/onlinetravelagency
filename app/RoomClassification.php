<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomClassification extends Model
{
    protected $fillable = ['name'];

    function category(){
    	$this->hasMany('App\RoomCategory');
    }
}
