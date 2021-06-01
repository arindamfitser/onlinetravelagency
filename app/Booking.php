<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = ['user_id', 'hotel_id', 'hotel_token', 'room_id', 'room_type', 'start_date', 'end_date', 'nights', 'carttotal', 'currency', 'status', 'type', 'booking_data', 'guest_details'];
}
