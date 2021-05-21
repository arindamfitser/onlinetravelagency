<?php

namespace App\Http\Controllers;
use App\Accommodations;
use App\Experiences;
use App\Inspirations;
use App\Species;
use App\Hotels;
use App\Pages;
use App\Posts;
use App\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
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
    public function index($slug)
    {   
        $xpages = array('hotels','contact','destinations','partners', 'testimonial');
        
        if(is_nav($slug) || in_array($slug, $xpages) ){
            return $this->pageData($slug);
        }else if($slug=='admin'){
            return redirect('/admin/dashboard');
        }else{
            $page = Pages::whereTranslation('page_slug', $slug, 'en')->first();
            if($page){
                return $this->pageData($slug);
            }else{
                return abort(404);
            }
            
        }

        //return view('home');
    }
    public function pageData($slug){
        switch ($slug) {
            case 'accommodation-types':
                $accommodation_types = Accommodations::where('status', '=', 1)->get()->all();
                return view('frontend.pages.'.$slug, compact('accommodation_types'));
                break;
             case 'experiences':
                $experiences = Experiences::where('status', '=', 1)->get()->all();
                return view('frontend.pages.'.$slug, compact('experiences'));
                break;
             case 'inspirations':
                $inspirations = Inspirations::where('status', '=', 1)->get()->all();
                return view('frontend.pages.'.$slug, compact('inspirations'));
                break;
             case 'target-species':
                $species = Species::where('status', '=', 1)->get()->all();
                return view('frontend.pages.'.$slug, compact('species'));
                break;
            case 'hotels':
                $hotels = Hotels::all();
                return view('frontend.pages.'.$slug, compact('hotels'));
                break;
            case 'contact':
                return view('frontend.pages.'.$slug);
                break;
            case 'destinations':
                $image  = DB::table('destination_image')->where('destination_image.id', '1')->get()->first();
                return view('frontend.pages.'.$slug, compact('image'));
                break; 
            case 'partners':
                $partners = Partner::where('status', '=', 1)->get()->all();
                  return view('frontend.pages.'.$slug, compact('partners'));
                break;  
            case 'testimonial':
                $testimonials = DB::table('testimonials')->select('*')->join('testimonials_translations', 'testimonials.id', '=', 'testimonials_translations.testimonials_id')->where('status', '=', 1)->orderBy('c_order', 'ASC')->get()->all();
                  return view('frontend.pages.'.$slug, compact('testimonials'));
                break; 
            case 'my_bookings':
                return redirect('login');
                break;
            default:
                $page = Pages::where('status', '=', 1)->whereTranslation('page_slug', $slug, 'en')->first();
                //var_dump($page);
                if($page){
                 return view('frontend.pages.cms', compact('page'));
                }else{
                   return view('errors.404'); 
                }
                break;
        }

    }
    public function preview($slug)
    {   
        return view('frontend.pages.preview');
    }
}
