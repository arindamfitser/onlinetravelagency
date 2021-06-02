<?php

namespace App\Http\Controllers\admin;
use App\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class TestimonialsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $testimonials = Testimonials::all();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.add');
    }

    public function doadd(Request $request)
    { 
        $this->validate($request, [
            'testimonials_name' => 'required|string|max:255',
            'testimonials_content' => 'required',
            'testimonials_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $lang =  \App::getLocale(); 
        $Info = Testimonials::create($request->all());
        $testimonial = Testimonials::find($Info->id);
        $file = $request->file('testimonials_image');
        if($file){
            $testimonials_image = $file->getClientOriginalName();
            $path = $request->testimonials_image->store('public/uploads');
            $testimonial->testimonials_image = $path;
        }
        $testimonial->save();
        return redirect()->back()->with('message', 'Testimonial added successfully!');
    }

    public function edit($lang, $id)
    {   $testimonial =  Testimonials::where('id', '=' , $id)->get()->first();
        $testimonial->translate($lang);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $lang, $id)
    {
        $lang =  \App::getLocale(); 
        $testimonial = Testimonials::find($id);
        $file = $request->file('testimonials_image');
        if($file){
            $testi = Testimonials::where('id', '=' , $id)->get()->first();
            if($testi->testimonials_image){
                Storage::delete($testi->testimonials_image);
            }
            $testimonials_image = $file->getClientOriginalName();
            $path = $request->testimonials_image->store('public/uploads');
            $testimonial->testimonials_image = $path;
        }
        $testimonial->locale = $lang;
        $testimonial->testimonials_name = $request->testimonials_name;
        $testimonial->testimonials_content = $request->testimonials_content;
        $testimonial->status = $request->status;
        $testimonial->c_order = $request->c_order;
        $testimonial->save();
        return redirect()->back()->with('message', 'Testimonial updated successfully!');
    }

    public function doDelete($lang, $id)
    {
        $testimonial = Testimonials::where('id', '=' , $id)->get()->first();
        $testimonial->translate($lang);
        if($testimonial->testimonials_image){
            Storage::delete($testimonial->testimonials_image);
        }
        Testimonials::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Testimonial deleted successfully!');
    }

    public function change_status(Request $request, $lang, $id){
        $testimonial = Testimonials::where('id', '=' , $id)->get()->first();
        $testimonial->translate($lang);
        if($request->status == 1){
            $testimonial->status = 1;
        }else{
            $testimonial->status = 0;
        }
        $testimonial->save();
        return redirect()->back()->with('message', 'Status changes successfully!');
    }
}
