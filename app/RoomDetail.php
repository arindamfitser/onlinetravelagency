<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomDetail extends Model
{
    protected $fillable = ['room_no', 'floor_no', 'room_id', 'bed_count', 'availability'];
}
