<?php

namespace App\Http\Controllers\Admin;
use App\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $packages = Package::where('hotel_id', '=', $id)->get();
        return view('admin.package.index', compact('id', 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.package.add',compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function do_add(Request $request, $id)
    {
        $this->validate($request, [
            'pkg_name' => 'required|string|max:255',
            'pkg_descp' => 'required',
            'pkg_price' => 'required',
            'pkg_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $package = new Package;
        $package->pkg_name = $request->pkg_name;
        $package->pkg_descp = $request->pkg_descp;
        $package->pkg_price = $request->pkg_price;
        $package->hotel_id = $id;
        $package->save();
        $package = Package::find($package->id);
        $file = $request->file('pkg_image');
        if($file){
            $pkg_image = $file->getClientOriginalName();
            $path = $request->pkg_image->store('public/uploads');
            $package->pkg_image = $path;
            $package->save();
        }
        return redirect()->back()->with('message', 'Package added successfully!');
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
        $package = Package::find($id);
        return view('admin.package.edit', compact('package'));
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
            'pkg_name' => 'required|string|max:255',
            'pkg_descp' => 'required',
            'pkg_price' => 'required',
            'pkg_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $package = Package::find($id);
        $package->pkg_name = $request->pkg_name;
        $package->pkg_descp = $request->pkg_descp;
        $package->pkg_price = $request->pkg_price;
        $file = $request->file('pkg_image');
        if($file){
            if($package->pkg_image){
                Storage::delete($package->pkg_image);
            }
            $pkg_image = $file->getClientOriginalName();
            $path = $request->pkg_image->store('public/uploads');
            $package->pkg_image = $path;
        }
        $package->save();
        return redirect()->back()->with('message', 'Package updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del($id)
    {
        $package = Package::where('id', '=' , $id)->get()->first();
        if($package->pkg_image){
            Storage::delete($package->pkg_image);
        }
        Package::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Package deleted successfully!');
    }
}
