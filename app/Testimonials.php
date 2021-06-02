<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Testimonials extends Model{
    protected $fillable = ['testimonials_name', 'testimonials_content', 'user_id'];
}