<?php

namespace App\Http\Controllers\Admin;
use App\Amenities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AmenitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {   
        $amenities = Amenities::all();
        return view('admin.amenities.index', compact('amenities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.amenities.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doadd(Request $request)
    {
        $this->validate($request, [
            'amenities_name' => 'required|string|max:255',
        ]);
        $lang =  \App::getLocale(); 
        $info =  Amenities::create($request->all());
        return redirect()->back()->with('message', 'Accommodation added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {       
        $amenities =  Amenities::where('id', '=' , $id)->get()->first();
        $amenities->translate($lang);
        return view('admin.amenities.edit', compact('amenities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
       $this->validate($request, [
            'amenities_name' => 'required|string|max:255',
        ]);
        $amenities = Amenities::where('id', '=' , $id)->get()->first();
        $lang =  \App::getLocale();
        $amenities->locale = $lang;
        $amenities->amenities_name = $request->amenities_name;
        $amenities->status = $request->status;
        $amenities->save();
        return redirect()->back()->with('message', 'Amenities added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doDelete($lang, $id)
    {
        $amenities = Amenities::where('id', '=' , $id)->get()->first();
        $amenities->translate($lang);
        Amenities::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Amenities deleted successfully!');
    }
}
