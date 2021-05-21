<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelGallery extends Model
{
     protected $fillable = ['hotel_id', 'image', 'image_alt'];
}
