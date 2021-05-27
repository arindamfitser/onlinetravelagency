<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Partner;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
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
        $partners = Partner::all();
        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partners.add');
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
            'partner_title' => 'required|string|max:255',
            'partner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $partner_title = $request->partner_title;
        $status = $request->status;
        $link = $request->link;
        $file = $request->file('partner_image');
        $partner = new Partner;
        if($file){
            $partner_image = $file->getClientOriginalName();
            $path = $request->partner_image->store('public/uploads');
            $partner->image = $path;
            $partner->title = $partner_title;
            $partner->status = $status;
            $partner->link = $link;
        }
        $partner->save();
        return redirect()->back()->with('message', 'Partner added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = Partner::find($id);
        return view('admin.partners.edit', compact('partner'));
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
            'partner_title' => 'required|string|max:255',
            'partner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $partner = Partner::find($id);
        $file = $request->file('partner_image');
        if($file){
            $partner = Partner::where('id', '=' , $id)->get()->first();
            if($partner->partner_image){
                Storage::delete($partner->partner_image);
            }
            $partner_image = $file->getClientOriginalName();
            $path = $request->partner_image->store('public/uploads');
            $partner->image = $path;
        }
        $partner->title = $request->partner_title;
        $partner->status = $request->status;
        $partner->link = $request->link;
        $partner->save();
        return redirect()->back()->with('message', 'Partner updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doDelete($id)
    {
        $partner = Partner::where('id', '=' , $id)->get()->first();
        if($partner->partner_image){
            Storage::delete($partner->partner_image);
        }
        Partner::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Partner deleted successfully!');
    }
    public function change_status(Request $request,  $id){
        $partner = Partner::where('id', '=' , $id)->get()->first();
        if($request->status == 1){
            $partner->status = 1;
        }else{
            $partner->status = 0;
        }
        $partner->save();
        return redirect()->back()->with('message', 'Status changes successfully!');
    }
}
