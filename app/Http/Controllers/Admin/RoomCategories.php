<?php
namespace App\Http\Controllers\admin;
use App\RoomCategory;
use App\RoomClassification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomCategories extends Controller
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
        $roomcategory = RoomCategory::all();
        return view('admin.Roomcategory.index', compact('roomcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $classification = RoomClassification::all();
        return view('admin.Roomcategory.add', compact('classification'));
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
        $roomcategory = RoomCategory::create($request->all());
        return redirect()->back()->with('message', 'Room category added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roomcategory =  RoomCategory::where('id', '=' , $id)->get()->first();
        $classification = RoomClassification::all();
        return view('admin.Roomcategory.edit', compact('roomcategory', 'classification'));
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
         $roomcategory =  RoomCategory::where('id', '=' , $id)->get()->first();
         $roomcategory->name = $request->name;
         $roomcategory->classification_id = $request->classification_id;
         $roomcategory->save();
         return redirect()->back()->with('message', 'Room category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doDelete($id)
    {
        RoomCategory::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Room category deleted successfully!');
    }
}
