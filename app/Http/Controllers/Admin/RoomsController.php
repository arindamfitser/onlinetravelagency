<?php
namespace App\Http\Controllers\Admin;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\PriceMatrix;
use App\Price;
use App\Amenities;
use App\RoomsAmenitie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
	public function rooms_list($lang,$id){
		$rooms = Rooms::where('hotel_id', '=', $id)->get();
		return view('admin.rooms.rooms', compact('id', 'rooms'));
	}

	public function rooms_add($lang,$id){    
    $roomcategory = RoomCategory::all();
    $amenities = Amenities::all();
    return view('admin.rooms.addroom', compact('id', 'roomcategory', 'amenities'));
  }

  public function rooms_doadd(Request $request,$lang, $id){
   $this->validate($request, [
    'name' => 'required',
    'room_capacity' => 'required|integer',
    'category' => 'required',
  ]);
   $rooms = new Rooms;
   $rooms->name = $request->name;
   $rooms->hotel_id = $id;
   $rooms->adult_capacity = $request->adult_capacity;
   $rooms->child_capacity = $request->child_capacity;
   $rooms->room_capacity = $request->room_capacity;
   $rooms->category = $request->category;
   $rooms->extra_bed = $request->extra_bed;
   $rooms->base_price = $request->base_price;
   $rooms->descp = $request->descp;
   $rooms->availability = $request->availability;
   $rooms->save();
   $room_id = $rooms->id;
   for ($i=0; $i < count($request->amenities) ; $i++) { 
     $roomsamenitie = new RoomsAmenitie;
     $roomsamenitie->room_id = $room_id;
     $roomsamenitie->amenities_id = $request->amenities[$i];
     $roomsamenitie->save();
   }
   $get_data = Rooms::where('id', '=', $room_id)->get()->first();

   echo json_encode(array('success'=>true,'message'=> 'Room Added successfully!', 'results' => $get_data));
   exit();
 }

 public function rooms_details_add(Request $request,$lang){
  $floor_no_arr =  $request->floor_no;
  for ($i=0; $i < count($floor_no_arr) ; $i++) { 
    $data['room_no'] = $request->room_no[$i];
    $data['floor_no'] = $request->floor_no[$i];
    $data['room_id'] = $request->room_id;
    $data['bed_count'] = $request->bed_count[$i];
    $data['availability'] = $request->{'availability_'.$i};
    RoomDetail::create($data);
  }
  $get_data = RoomDetail::where('room_id', '=', $request->room_id)->get()->first();
  echo json_encode(array('success'=>true,'message'=> 'Room Added successfully!', 'results' => $get_data));
  exit();
}

public function rooms_gallery_add(Request $request,$lang){
  $featured_image = $request->file('featured_image');
  $id = $request->room_id;
  if($featured_image){
    $rooms = Rooms::find($id);
    $featured_image = $featured_image->getClientOriginalName();
    $path = $request->featured_image->store('public/uploads');
    $rooms->featured_image = $path;
    $rooms->save();
  }
  $gallery_images = $request->gallery_image;
  if(!empty($gallery_images)){
    for ($i=0; $i < count($gallery_images) ; $i++) { 
     $gallery_image = $request->file('gallery_image')[0];
     if($gallery_image){
      $gallery_image = $gallery_image->getClientOriginalName();
      $path = $request->gallery_image[$i]->store('public/uploads');
      $data = array();
      $data['room_id'] = $id;
      $data['image'] = $path;
      RoomGallery::create($data);
    }   
  }
}
return redirect()->back();

}

public function rooms_edit($lang,$id){
  $rooms = Rooms::where('id', '=', $id)->get()->first();
  $amenities = Amenities::all();
  $roomsamenitie = RoomsAmenitie::where('room_id', '=', $id)->get();
  $roomcategory = RoomCategory::all();
  $rooms_details = RoomDetail::where('room_id', '=', $id)->get();
  $roomgallery = RoomGallery::where('room_id', '=', $id)->get();
  return view('admin.rooms.editroom', compact('id', 'rooms', 'roomcategory', 'rooms_details', 'roomgallery', 'amenities', 'roomsamenitie'));
}

public function updateroom(Request $request,$lang, $id){
  $rooms = Rooms::where('id', '=', $id)->get()->first();
  $rooms->name = $request->name;
  $rooms->adult_capacity = $request->adult_capacity;
  $rooms->child_capacity = $request->child_capacity;
  /*$rooms->room_capacity = $request->room_capacity;*/
  $rooms->category = $request->category;
  $rooms->extra_bed = $request->extra_bed;
  $rooms->descp = $request->descp;
  $rooms->availability = $request->availability;
  $rooms->save();
  if(!empty($request->amenities)){
    RoomsAmenitie::where('room_id', '=', $id)->delete();
    for ($i=0; $i < count($request->amenities) ; $i++) { 
      $roomsamenitie = new RoomsAmenitie;
      $roomsamenitie->room_id = $id;
      $roomsamenitie->amenities_id = $request->amenities[$i];
      $roomsamenitie->save();
    }
  }
  echo json_encode(array('success'=>true,'message'=> 'Room Updated successfully!'));
  exit();
}

public function editetails(Request $request,$lang, $id){
  RoomDetail::where('room_id', '=', $id)->delete();
  $floor_no_arr =  $request->floor_no;
  for ($i=0; $i < count($floor_no_arr) ; $i++) { 
    $data['room_no'] = $request->room_no[$i];
    $data['floor_no'] = $request->floor_no[$i];
    $data['room_id'] = $id;
    $data['bed_count'] = $request->bed_count[$i];
    $data['availability'] = $request->{'availability_'.$i};
    RoomDetail::create($data);
  }
  echo json_encode(array('success'=>true,'message'=> 'Details Updated successfully!'));
  exit();

}

public function editgallery(Request $request,$lang, $id){
  $featured_image = $request->file('featured_image');
  if($featured_image){
    $rooms = Rooms::find($id);
    $featured_image = $featured_image->getClientOriginalName();
    $path = $request->featured_image->store('public/uploads');
    $rooms->featured_image = $path;
    $rooms->save();
  }
  $gallery_images = $request->gallery_image;
  if(!empty($gallery_images)){
    
    for ($i=0; $i < count($gallery_images) ; $i++) { 
     $gallery_image = $request->file('gallery_image')[0];
     if($gallery_image){
      $gallery_image = $gallery_image->getClientOriginalName();
      $path = $request->gallery_image[$i]->store('public/uploads');
      $data = array();
      $data['room_id'] = $id;
      $data['image'] = $path;
      RoomGallery::create($data);
    }   

  }
}
return redirect()->back();
}

public function price_rack($lang,$id){
  $price = Price::where('room_id', '=', $id)->get();
  return view('admin.rooms.price', compact('id', 'price'));
}

public function price_edit($lang,$id){
  $price_rack = PriceMatrix::where('price_id', '=', $id)->get();
  $Price = Price::where('id', '=', $id)->get();
  echo json_encode(array('price_rack' => $price_rack, 'price' => $Price));
}

public function addprice(Request $request,$lang, $id){
  $price_id = $request->price_id;
  $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
  if($price_id){
    $price = Price::find($price_id);
    $eff_start_date = date('Y-m-d', strtotime($request->eff_start_date));
    $eff_end_date = date('Y-m-d', strtotime($request->eff_end_date));
    $price->room_id = $id;
    $price->base_price = $request->base_price;
    $price->extra_bed = $request->extra_bed;
    $price->per_person = $request->food_rate;
    $price->per_child = $request->child_rate;
    $price->eff_start_date = $eff_start_date;
    $price->eff_end_date = $eff_end_date;
    $price->save();
    PriceMatrix::where('price_id', '=', $price_id)->delete();
    for ($i=0; $i < count($days) ; $i++) { 
      $day = $days[$i];
      $method = $request->{strtolower($day).'_method'};
      $per = $request->{strtolower($day).'_per'};
      $price = $request->{strtolower($day).'_price'};
      $ex_price = $request->{strtolower($day).'_ex_price'};
      $food_rate = $request->{strtolower($day).'_food_rate'};
      $child_rate = $request->{strtolower($day).'_child_rate'};
      $pricematrix = new PriceMatrix;
      $pricematrix->room_id = $id;
      $pricematrix->days = $day;
      $pricematrix->method = $method;
      $pricematrix->rate = $per;
      $pricematrix->base_price = $price;
      $pricematrix->price_id = $price_id;
      $pricematrix->extra_bed = $ex_price;
      $pricematrix->per_person = $food_rate;
      $pricematrix->per_child = $child_rate;
      $pricematrix->eff_start_date = $eff_start_date;
      $pricematrix->eff_end_date = $eff_end_date;
      $pricematrix->save();
    }
    echo json_encode(array('success'=>true, 'message'=> 'Price updated successfully!'));
    exit();
  }else{
    $price = new Price;
    $eff_start_date = date('Y-m-d', strtotime($request->eff_start_date));
    $eff_end_date = date('Y-m-d', strtotime($request->eff_end_date));
    $price->room_id = $id;
    $price->base_price = $request->base_price;
    $price->extra_bed = $request->extra_bed;
    $price->per_person = $request->food_rate;
    $price->per_child = $request->child_rate;
    $price->eff_start_date = $eff_start_date;
    $price->eff_end_date = $eff_end_date;
    $price->save();
    $price_id = $price->id;
    for ($i=0; $i < count($days) ; $i++) { 
      $day = $days[$i];
      $method = $request->{strtolower($day).'_method'};
      $per = $request->{strtolower($day).'_per'};
      $price = $request->{strtolower($day).'_price'};
      $ex_price = $request->{strtolower($day).'_ex_price'};
      $food_rate = $request->{strtolower($day).'_food_rate'};
      $child_rate = $request->{strtolower($day).'_child_rate'};
      $pricematrix = new PriceMatrix;
      $pricematrix->room_id = $id;
      $pricematrix->days = $day;
      $pricematrix->method = $method;
      $pricematrix->rate = $per;
      $pricematrix->base_price = $price;
      $pricematrix->price_id = $price_id;
      $pricematrix->extra_bed = $ex_price;
      $pricematrix->per_person = $food_rate;
      $pricematrix->per_child = $child_rate;
      $pricematrix->eff_start_date = $eff_start_date;
      $pricematrix->eff_end_date = $eff_end_date;
      $pricematrix->save();
    }
    echo json_encode(array('success'=>true,'message'=> 'Price added successfully!', 'pricematrix' => $pricematrix));
  }
}

public function delprice($lang,$id){
  Price::where('id', $id)->delete();
  return redirect()->back()->with('message', 'price deleted successfully!');
}
public function delroom($lang,$id){
 Rooms::where('id', $id)->delete();
 RoomDetail::where('room_id', '=', $id)->delete();
 RoomGallery::where('room_id', '=', $id)->delete();
 return redirect()->back()->with('message', 'Room deleted successfully!');
} 
public function delGalleryImage(Request $request,$lang){

  $gld=RoomGallery::where('id', '=', $request->key)->get()->first();
  Storage::Delete($gld->image);
  RoomGallery::where('id', '=', $request->key)->delete();
  $output = array('success' => 'Successfully Deleted' );
  echo json_encode($gld); 
  exit;
} 
}
