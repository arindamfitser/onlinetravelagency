<?php
namespace App\Http\Controllers\admin;
use App\KeyFeature;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class DestinationImageController extends Controller
{   
    public function __construct(){
        $this->middleware('auth:admin');
    }
    public function index(){
        $image  = DB::table('destination_image')->where('destination_image.id', '1')->get()->first();
        return view('admin.destination-image.index', compact('image'));
    }
    public function edit($id){
        $image  = DB::table('destination_image')->where('destination_image.id', $id)->get()->first();
        return view('admin.destination-image.edit', compact('image'));
    }
    public function doEdit(Request $request, $id){
        if($request->hasFile('imageFile')) {
            $icons              = $request->file('imageFile');
            $filename           = pathinfo($icons->getClientOriginalName(), PATHINFO_FILENAME).rand().'.'.$icons->getClientOriginalExtension();
            $destinationPath    = public_path('storage/uploads/destination-image/');
            $icons->move($destinationPath, $filename);
            DB::table('destination_image')
                ->where('id', $id)
                ->update(['image' => $filename]);
            return redirect()->back()->with('message', 'Destination Image updated successfully!');
        }else{
            return redirect()->back()->with('message', 'No Image To Update!');
        }
    }
}
