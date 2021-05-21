<?php

namespace App\Http\Controllers\admin;
use App\Accommodations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AccommodationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $accommodations =  Accommodations::all();
        return view('admin.accommodations.index', compact('accommodations'));
    }

    public function create()
    {
        return view('admin.accommodations.add');
    }

   
    public function doadd(Request $request)
    {   
        $this->validate($request, [
            'accommodations_name' => 'required|string|max:255',
            'accommodations_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $lang =  \App::getLocale(); 
        $info =  Accommodations::create($request->all());
        $accommodations = Accommodations::find($info->id);
        $file = $request->file('accommodations_image');
        if($file){
            $accommodations_image = $file->getClientOriginalName();
            $path = $request->accommodations_image->store('public/uploads');
            $accommodations->accommodations_image = $path;
        }
        $accommodations->save();
        return redirect()->back()->with('message', 'Accommodation added successfully!');
    }

    public function edit($lang, $id)
    {   
        $accommodation =  Accommodations::where('id', '=' , $id)->get()->first();
        $accommodation->translate($lang);
        return view('admin.accommodations.edit', compact('accommodation'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'accommodations_name' => 'required|string|max:255',
            'accommodations_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $accommodation = Accommodations::where('id', '=' , $id)->get()->first();
        $lang =  \App::getLocale(); 
        $file = $request->file('accommodations_image');
        if($file){
            if($accommodation->accommodations_image){
                Storage::delete($accommodation->accommodations_image);
            }
            $accommodations_image = $file->getClientOriginalName();
            $path = $request->accommodations_image->store('public/uploads');
            $accommodation->accommodations_image = $path;
        }
        $accommodation->locale = $lang;
        $accommodation->accommodations_name = $request->accommodations_name;
        $accommodation->accommodations_slug = $request->accommodations_slug;
        $accommodation->status = $request->status;
        $accommodation->save();
        return redirect()->back()->with('message', 'Accommodation updated successfully!');
    }

    public function doDelete($lang, $id)
    {
        $accommodation = Accommodations::where('id', '=' , $id)->get()->first();
        $accommodation->translate($lang);
        if($accommodation->accommodations_image){
            Storage::delete($accommodation->accommodations_image);
        }
        Accommodations::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Accommodation deleted successfully!');
    }
    public function change_status(Request $request,  $id){
        $accommodation = Accommodations::where('id', '=' , $id)->get()->first();
        if($request->status == 1){
            $accommodation->status = 1;
        }else{
            $accommodation->status = 0;
        }
        $accommodation->save();
        return redirect()->back()->with('message', 'Status changes successfully!');
    }
}
