<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Review extends Model{
    protected $fillable = ['hotel_id', 'user_id', 'rating', 'subjects', 'comments'];
}