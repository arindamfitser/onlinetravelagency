<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    protected $fillable = ['booking_id', 'hotel_id', 'hotel_token', 'hotel_token', 'room_id', 'room_type', 'user_id', 'base_price', 'price', 'discount', 'total_price', 'nights', 'room_details_id', 'check_in', 'check_out', 'start_date', 'end_date', 'quantity_adults', 'quantity_child', 'quantity_room', 'status'];
}
