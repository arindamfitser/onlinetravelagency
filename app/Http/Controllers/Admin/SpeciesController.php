<?php

namespace App\Http\Controllers\Admin;
use App\Species;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SpeciesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {   
        $species = Species::all();
        return view('admin.species.index', compact('species'));
    }

    public function create()
    {
        return view('admin.species.add');
    }

    public function doadd(Request $request)
    {   
        $this->validate($request, [
            'species_name' => 'required|string|max:255',
            'species_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $lang =  \App::getLocale();
        $info = Species::create($request->all());
        $species = Species::find($info->id);
        $file = $request->file('species_image');
        if($file){
            $species_image = $file->getClientOriginalName();
            $path = $request->species_image->store('public/uploads');
            $species->species_image = $path;
        }
        $species->save();
        return redirect()->back()->with('message', 'Species added successfully!');
    }

    public function edit($lang, $id)
    {
        $species =  Species::where('id', '=' , $id)->get()->first();
        $species->translate($lang);
        return view('admin.species.edit', compact('species'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'species_name' => 'required|string|max:255',
            'species_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $species = Species::where('id', '=' , $id)->get()->first();
        $file = $request->file('species_image');
        if($file){
            if($species->species_image){
                Storage::delete($species->species_image);
            }
            $species_image = $file->getClientOriginalName();
            $path = $request->species_image->store('public/uploads');
            $species->species_image = $path;
        }
        $species->locale = $lang;
        $species->species_name = $request->species_name;
        $species->status = $request->status;
        $species->save();
        return redirect()->back()->with('message', 'Species updated successfully!');
    }

    public function doDelete($lang, $id)
    {
        $species = Species::where('id', '=' , $id)->get()->first();
        $species->translate($lang);
        if($species->species_image){
            Storage::delete($species->species_image);
        }
        Species::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Species deleted successfully!');
    }
   public function change_status(Request $request,  $id){
        $species = Species::where('id', '=' , $id)->get()->first();
        if($request->status == 1){
            $species->status = 1;
        }else{
            $species->status = 0;
        }
        $species->save();
        return redirect()->back()->with('message', 'Status changes successfully!');
    }
}
