<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\RoomFacility;
use App\Http\Controllers\Controller;

class RoomFacilitiesController extends Controller
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
        $roomfacility = RoomFacility::all();
        return view('admin.room_facilities.index', compact('roomfacility'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.room_facilities.add');
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
        $info =  RoomFacility::create($request->all());
        return redirect()->back()->with('message', 'Room Facility added successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roomfacility = RoomFacility::find($id);
        return view('admin.room_facilities.edit', compact('roomfacility'));
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
        $roomfacility = RoomFacility::where('id', '=' , $id)->get()->first();
        $roomfacility->name = $request->name;
        $roomfacility->status = $request->status;
        $roomfacility->save();
        return redirect()->back()->with('message', 'Room Facility updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doDelete($id)
    {
        RoomFacility::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Room Facility deleted successfully!');
    }
}
