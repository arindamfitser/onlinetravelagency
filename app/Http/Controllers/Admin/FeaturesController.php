<?php

namespace App\Http\Controllers\admin;
use App\KeyFeature;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FeaturesController extends Controller
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
        $keyfeature = KeyFeature::all();
        return view('admin.features.index', compact('keyfeature'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.features.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doadd(Request $request)
    {
        /*print_r($request->all());
        exit();*/
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);
        $info =  KeyFeature::create($request->all());
        if($request->hasFile('icons')) {
            $icons       = $request->file('icons');
            $filename    = pathinfo($icons->getClientOriginalName(), PATHINFO_FILENAME).rand().'.'.$icons->getClientOriginalExtension();;
            //$image_resize = Image::make($icons)->fit(92)->encode('png');              
            //$image_resize->resize(92, 92);
            $destinationPath = storage_path('app/public/uploads/icons/');
            $icons->move($destinationPath, $filename);
            //$path =  Storage::disk('public')->put( 'uploads/icons/'.$filename, $image_resize);
            $keyfeature = KeyFeature::where('id', '=', $info->id)->get()->first();
            $keyfeature->icons = $filename;
            $keyfeature->save();
        }
        //exit();
        return redirect()->back()->with('message', 'Features added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $keyfeature = KeyFeature::find($id);
        return view('admin.features.edit', compact('keyfeature'));
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
        $keyfeature = KeyFeature::where('id', '=' , $id)->get()->first();
        $keyfeature->name = $request->name;
        if($request->hasFile('icons')) {
            $icons       = $request->file('icons');
            $filename    = pathinfo($icons->getClientOriginalName(), PATHINFO_FILENAME).rand().'.'.$icons->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/uploads/icons/');
            $icons->move($destinationPath, $filename);
            /*$image_resize = Image::make($icons)->fit(92)->encode('png');
            $path =  Storage::disk('public')->put( 'uploads/icons/'.$filename, $image_resize);*/

            $keyfeature->icons = $filename;
        }
        $keyfeature->status = $request->status;
        $keyfeature->save();
        return redirect()->back()->with('message', 'Features updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doDelete($id)
    {
        $keyfeature = KeyFeature::where('id', '=' , $id)->get()->first();
        if($keyfeature->icons){
            Storage::delete('uploads/icons/'.$keyfeature->icons);
        }
        KeyFeature::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Features deleted successfully!');
    }
}
