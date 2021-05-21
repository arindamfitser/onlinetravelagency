<?php
namespace App\Http\Controllers\Admin;
use App\User;
use App\Admin;
use App\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
class BannersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {   
        $banners = Banners::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.add');
    }

    public function doCreate(Request $request)
    {   $this->validate($request, [
            'banners_title' => 'required|string|max:255',
            'banners_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $lang =  \App::getLocale(); 
        $Info = Banners::create($request->all());
        $banners = Banners::find($Info->id);
        $file = $request->file('banners_image');
        if($file){
            $banners_image = $file->getClientOriginalName();
            $path = $request->banners_image->store('public/uploads');
            $banners->banners_image = $path;
        }
        $banners->save();
        return redirect()->back()->with('message', 'Banner added successfully!');
    }

    public function edit($lang,$id)
    {
        $banner =  Banners::where('id', '=' , $id)->get()->first();
        $banner->translate($lang);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'banners_title' => 'required|string|max:255',
            'banners_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $lang =  \App::getLocale(); 
        $banners = Banners::find($id);
        $file = $request->file('banners_image');
        if($file){
            $banner = Banners::where('id', '=' , $id)->get()->first();
            if($banner->banners_image){
                Storage::delete($banner->banners_image);
            }
            $banners_image = $file->getClientOriginalName();
            $path = $request->banners_image->store('public/uploads');
            $banners->banners_image = $path;
        }
        $banners->locale = $lang;
        $banners->banners_title = $request->banners_title;
        $banners->banners_description = $request->banners_description;
        $banners->banners_link = $request->banners_link;
        $banners->status = $request->status;
        $banners->save();
        return redirect()->back()->with('message', 'Banner updated successfully!');
        
    }

    public function doDelete($lang,$id)
    {
        $banner = Banners::where('id', '=' , $id)->get()->first();
        $banner->translate($lang);
        if($banner->banners_image){
            Storage::delete($banner->banners_image);
        }
        Banners::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Banner deleted successfully!');
    }
}
