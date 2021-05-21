<?php

namespace App\Http\Controllers\admin;

use App\ServiceFacility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceFacilities extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicefacility = ServiceFacility::all();
        return view('admin.service_facilities.index', compact('servicefacility'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service_facilities.add');
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
            'name' => 'required|string|max:255',
        ]);
        $info =  ServiceFacility::create($request->all());
        return redirect()->back()->with('message', 'Service & Facility added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $servicefacility = ServiceFacility::where('id', '=' , $id)->get()->first();
        return view('admin.service_facilities.edit', compact('servicefacility'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);
        $servicefacility = ServiceFacility::where('id', '=' , $id)->get()->first();
        $servicefacility->name = $request->name;
        $servicefacility->status = $request->status;
        $servicefacility->save();
        return redirect()->back()->with('message', 'Service & Facility updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doDelete($id)
    {
        ServiceFacility::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Service & Facility deleted successfully!');
    }
}
