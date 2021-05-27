<?php
namespace App\Http\Controllers\admin;
use App\KeyFeature;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class StubaHotelImageController extends Controller
{   
    public function __construct(){
        $this->middleware('auth:admin');
    }
    public function index(){
        return view('admin.hotel-image.index');
    }
    public function fetchImage(Request $request){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '90000000000000');
        $hotels         = DB::table('hotel_master_xml')
                        ->select('hotel_master_xml.id', 'hotel_master_xml.name', 'hotel_main_image.image')
                        ->leftJoin('hotel_main_image', function($join) {
                            $join->on('hotel_main_image.hotel_id', '=', 'hotel_master_xml.id');
                        })
                        ->orderBy('hotel_master_xml.id', 'ASC')->skip(0)->take(500)->get();
        $html           = view('admin.hotel-image.ajax.ajax', compact('hotels'))->render();
        print json_encode(array(
            "html"            => $html
        ));
    }
    public function edit($id){
        $hotel          = DB::table('hotel_master_xml')
                        ->select('hotel_master_xml.id', 'hotel_master_xml.name', 'hotel_main_image.image')
                        ->leftJoin('hotel_main_image', function($join) {
                            $join->on('hotel_main_image.hotel_id', '=', 'hotel_master_xml.id');
                        })
                        ->where('hotel_master_xml.id', $id)->get()->first();
        $hotelImages    = DB::table('hotel_images_xml')
                        ->select('hotel_images_xml.Url')
                        ->where('hotel_images_xml.hotel_id', $id)->get();
        return view('admin.hotel-image.edit', compact('hotel', 'hotelImages'));
    }
    public function doEdit(Request $request, $id){
        $msg = 'No Image Selected!';
        if(!empty($request->image)) {
            $check = DB::table('hotel_main_image')->select('hotel_main_image.id')->where('hotel_main_image.hotel_id', $request->hotel_id)->get()->first();
            if(empty($check)):
                DB::table('hotel_main_image')
                ->insert(
                     array(
                        'hotel_id'  =>   $request->hotel_id, 
                        'image'     =>   $request->image
                     )
                );
                $msg = 'Hotel Main Image added successfully!';
            else:
                DB::table('hotel_main_image')
                ->where('hotel_id', $request->hotel_id)
                ->update(['image' => $request->image]);
                $msg = 'Hotel Main Image updated successfully!';
            endif;
        }
        return redirect()->back()->with('message', $msg);
    }
}
