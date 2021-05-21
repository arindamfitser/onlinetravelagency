<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestimonialsTranslation extends Model
{
    public $timestamps = false;

        protected $fillable = ['locale', 'testimonials_name', 'testimonials_content', 'testimonials_image', 'c_order', 'user_id'];
}
