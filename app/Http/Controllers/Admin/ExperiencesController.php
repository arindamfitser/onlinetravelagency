<?php

namespace App\Http\Controllers\admin;
use App\Experiences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ExperiencesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $experiences = Experiences::all();
        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.add');
    }

    public function doadd(Request $request)
    {
        $this->validate($request, [
            'experiences_name' => 'required|string|max:255',
            'experiences_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $lang =  \App::getLocale();
        $info = Experiences::create($request->all());
        $experiences = Experiences::find($info->id);
        $file = $request->file('experiences_image');
        if($file){
            $experiences_image = $file->getClientOriginalName();
            $path = $request->experiences_image->store('public/uploads');
            $experiences->experiences_image = $path;
        }
        $experiences->save();
        return redirect()->back()->with('message', 'Experiences added successfully!');
    }

    public function edit($lang, $id)
    {
        $experience =  Experiences::where('id', '=' , $id)->get()->first();
        $experience->translate($lang);
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'experiences_name' => 'required|string|max:255',
            'experiences_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $experience = Experiences::where('id', '=' , $id)->get()->first();
        $file = $request->file('experiences_image');
        if($file){
            if($experience->experiences_image){
                Storage::delete($experience->experiences_image);
            }
            $experiences_image = $file->getClientOriginalName();
            $path = $request->experiences_image->store('public/uploads');
            $experience->experiences_image = $path;
        }
        $experience->locale = $lang;
        $experience->experiences_name = $request->experiences_name;
        $experience->status = $request->status;
        $experience->save();
        return redirect()->back()->with('message', 'Experiences updated successfully!');
    }

    public function doDelete($lang, $id)
    {
        $experience = Experiences::where('id', '=' , $id)->get()->first();
        $experience->translate($lang);
        if($experience->experiences_name){
            Storage::delete($experience->experiences_name);
        }
        Experiences::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Experiences deleted successfully!');
    }
}
