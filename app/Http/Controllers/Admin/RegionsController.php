<?php

namespace App\Http\Controllers\admin;
use App\Regions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $regions = Regions::all();
        return view('admin.regions.index', compact('regions'));
    }

    public function create()
    {
        return view('admin.regions.add');
    }

    public function doadd(Request $request)
    {
        $this->validate($request, [
            'regions_name' => 'required|string|max:255',
        ]);
        $lang =  \App::getLocale();
        $info = Regions::create($request->all());
        return redirect()->back()->with('message', 'Regions added successfully!');
    }

    public function edit($lang, $id)
    {
        $region =  Regions::where('id', '=' , $id)->get()->first();
        $region->translate($lang);
        return view('admin.regions.edit', compact('region'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'regions_name' => 'required|string|max:255',
        ]);
        $regions = Regions::where('id', '=' , $id)->get()->first();
        $regions->locale = $lang;
        $regions->regions_name = $request->regions_name;
        $regions->status = $request->status;
        $regions->save();
        return redirect()->back()->with('message', 'Regions updated successfully!');
    }

    public function doDelete($lang, $id)
    {
        $regions = Regions::where('id', '=' , $id)->get()->first();
        $regions->translate($lang);
        Regions::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Regions deleted successfully!');
    }
}
