<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomCount extends Model
{
    protected $fillable = ['room_id', 'dt', 'count'];
}
