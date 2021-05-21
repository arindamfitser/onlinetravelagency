<?php

namespace App\Http\Controllers;
use App\Banners;
use App\Accommodations;
use App\Experiences;
use App\Inspirations;
use App\Partner;
use App\Hotels;
use App\Testimonials;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banners::all();
        $accommodations = Accommodations::all();
        $experiences = Experiences::all();
        $inspirations = Inspirations::all();
        $partners = Partner::all();
        $testimonials = Testimonials::all();
         return view('home', compact('banners', 'accommodations', 'experiences', 'inspirations', 'partners', 'hotels', 'testimonials'));
    }
}
