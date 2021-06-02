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
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
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
        $banners = Banners::where('status', '=', 1)->get()->all();
        $accommodations = Accommodations::where('status', '=', 1)->get()->all();
        $experiences = Experiences::where('status', '=', 1)->get()->all();
        $inspirations = Inspirations::where('status', '=', 1)->get()->all();
        $partners = Partner::where('status', '=', 1)->get()->all();
        $hotels = Hotels::orderBy('id', 'DESC')->limit(12)->get()->all();
        //$testimonials = DB::table('testimonials')->select('*')->join('testimonials_translations', 'testimonials.id', '=', 'testimonials_translations.testimonials_id')->where('status', '=', 1)->orderBy('c_order', 'ASC')->get()->all();
        $testimonials = Testimonials::where('status', 1)->orderBy('id', 'DESC')->get()->all();
        return view('home', compact('banners', 'accommodations', 'experiences', 'inspirations', 'partners', 'hotels', 'testimonials'));
    }
}
