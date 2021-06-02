<?php

namespace App\Http\Controllers\admin;
use App\RoomClassification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassificationController extends Controller
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
        $classification = RoomClassification::all();
        return view('admin.Classification.index', compact('classification'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Classification.add');
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
        $info = RoomClassification::create($request->all());
        return redirect()->back()->with('message', 'Classification added successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classification = RoomClassification::where('id', '=', $id)->get()->first();
        return view('admin.Classification.edit', compact('classification'));
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
        $classification = RoomClassification::where('id', '=', $id)->get()->first();
        $classification->name = $request->name;
        $classification->save();
        return redirect()->back()->with('message', 'Accommodation added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doDelete($id)
    {
        RoomClassification::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Classification deleted successfully!');
    }
}
