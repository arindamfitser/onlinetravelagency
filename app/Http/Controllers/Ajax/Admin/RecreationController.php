<?php

namespace App\Http\Controllers\admin;
use App\Recreation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecreationController extends Controller
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
        $recreations = Recreation::all();
        return view('admin.recreation.index', compact('recreations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.recreation.add');
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
        $info =  Recreation::create($request->all());
        return redirect()->back()->with('message', 'Recreation added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recreation = Recreation::find($id);
        return view('admin.recreation.edit', compact('recreation'));
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
        $recreation = Recreation::where('id', '=' , $id)->get()->first();
        $recreation->name = $request->name;
        $recreation->status = $request->status;
        $recreation->save();
        return redirect()->back()->with('message', 'Recreation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doDelete($id)
    {
        Recreation::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Recreation deleted successfully!');
    }
}
