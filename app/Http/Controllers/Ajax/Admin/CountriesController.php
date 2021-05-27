<?php

namespace App\Http\Controllers\Admin;
use App\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CountriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $countries = Countries::all();
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.add');
    }

    public function doadd(Request $request)
    {
        $this->validate($request, [
            'countries_name' => 'required|string|max:255',
            'countries_sortname' => 'required|string|max:255',
            'countries_phonecode' => 'required|integer',
        ]);
        $lang =  \App::getLocale(); 
        $dataInfo = Countries::create($request->all());
        return redirect()->back()->with('message', 'Country added successfully!');
    }

    public function edit($lang,$id)
    {
        $country =  Countries::where('id', '=' , $id)->get()->first();
        $country->translate($lang);
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'countries_name' => 'required|string|max:255',
            'countries_sortname' => 'required|string|max:255',
            'countries_phonecode' => 'required|integer',
        ]);
        $lang =  \App::getLocale(); 
        $country = Countries::where('id', '=' , $id)->get()->first();
        $country->locale = $lang;
        $country->countries_name = $request->countries_name;
        $country->countries_sortname = $request->countries_sortname;
        $country->countries_phonecode = $request->countries_phonecode;
        $country->status = $request->status;
        $country->save();
        return redirect()->back()->with('message', 'Country updated successfully!');
    }

    public function doDelete($lang,$id)
    {
        $country = Countries::where('id', '=' , $id)->get()->first();
        $country->translate($lang);
        Countries::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Country deleted successfully!');
    }
    public function change_status(Request $request,  $id){
        $country = Countries::where('id', '=' , $id)->get()->first();
        if($request->status == 1){
            $country->status = 1;
        }else{
            $country->status = 0;
        }
        $country->save();
        return redirect()->back()->with('message', 'Status changes successfully!');
    }
  
}
