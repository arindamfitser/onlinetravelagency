<?php

namespace App\Http\Controllers\admin;
use App\Inspirations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class InspirationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $inspirations = Inspirations::all();
        return view('admin.inspirations.index', compact('inspirations'));
    }

    public function create()
    {
        return view('admin.inspirations.add');
    }

    public function doadd(Request $request)
    {
        $this->validate($request, [
            'inspirations_name' => 'required|string|max:255',
            'inspirations_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $lang =  \App::getLocale();
        $info = Inspirations::create($request->all());
        $inspiration = Inspirations::find($info->id);
        $file = $request->file('inspirations_image');
        if($file){
            $inspirations_image = $file->getClientOriginalName();
            $path = $request->inspirations_image->store('public/uploads');
            $inspiration->inspirations_image = $path;
        }
        $inspiration->save();
        return redirect()->back()->with('message', 'Inspirations added successfully!');
    }

    public function edit($lang, $id)
    {
        $inspiration =  Inspirations::where('id', '=' , $id)->get()->first();
        $inspiration->translate($lang);
        return view('admin.inspirations.edit', compact('inspiration'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'inspirations_name' => 'required|string|max:255',
            'inspirations_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $inspiration = Inspirations::where('id', '=' , $id)->get()->first();
        $lang =  \App::getLocale(); 
        $file = $request->file('inspirations_image');
        if($file){
            if($inspiration->inspirations_image){
                Storage::delete($inspiration->inspirations_image);
            }
            $inspirations_image = $file->getClientOriginalName();
            $path = $request->inspirations_image->store('public/uploads');
            $inspiration->inspirations_image = $path;
        }
        $inspiration->locale = $lang;
        $inspiration->inspirations_name = $request->inspirations_name;
        $inspiration->status = $request->status;
        $inspiration->save();
        return redirect()->back()->with('message', 'Inspirations updated successfully!');
    }

    public function doDelete($lang, $id)
    {
        $inspiration = Inspirations::where('id', '=' , $id)->get()->first();
        $inspiration->translate($lang);
        if($inspiration->inspirations_image){
            Storage::delete($inspiration->inspirations_image);
        }
        Inspirations::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Inspirations deleted successfully!');
    }
    public function change_status(Request $request,  $id){
        $inspiration = Inspirations::where('id', '=' , $id)->get()->first();
        if($request->status == 1){
            $inspiration->status = 1;
        }else{
            $inspiration->status = 0;
        }
        $inspiration->save();
        return redirect()->back()->with('message', 'Status changes successfully!');
    }
}
