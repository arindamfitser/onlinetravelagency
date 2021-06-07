<?php
namespace App\Http\Controllers;
use App\Hotels;
use App\HotelNewEntry;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\PriceMatrix;
use App\Price;
use App\RoomAvailability;
use App\Amenities;
use App\RoomsAmenitie;
use App\RoomAllocation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RoomsController extends Controller{
    public function __construct(){
        //$this->middleware('auth');
    }
    public function commonChangeStatus(Request $request){
        DB::table($request->table)
            ->where($request->tableKey, $request->id)
            ->update([$request->statusKey => $request->status]);
        print json_encode(array(
            'html'  => ($request->status == 1) ? '<i class="fa fa-check green-check-icon" aria-hidden="true"></i>' : '<i class="fa fa-times red-check-icon" aria-hidden="true"></i>',
            'stat'  => (string) $request->status
        ));
    }
	public function rooms_list($id){
		$rooms = Rooms::where('hotel_id', '=', $id)->get();
		return view('frontend.hotelier.rooms', compact('id', 'rooms'));
	}
	public function rooms_add($id){
        $roomcategory   = RoomCategory::all();
        $amenities      = Amenities::all();
		return view('frontend.hotelier.addroom', compact('id', 'roomcategory', 'amenities'));
	}
    public function rooms_doadd(Request $request, $id){
        $hotel                      = HotelNewEntry::find($id);
    	$rooms                      = new Rooms;
    	$featured_image             = $request->file('featured_image');
    	$img                        = '';
        if($featured_image):
            $img                    = time().$featured_image->getClientOriginalName();
            $request->featured_image->move(public_path('uploads'), $img);
        endif;
        $rooms->featured_image      = $img;
    	$rooms->name                = $request->name;
    	$rooms->hotel_token         = $hotel->hotel_token;
    	$rooms->hotel_id            = $id;
    	$rooms->adult_capacity      = $request->adult_capacity;
    	$rooms->child_capacity      = $request->child_capacity;
        $rooms->room_capacity       = $request->room_capacity;
        $rooms->extra_bed           = $request->extra_bed;
        $rooms->descp               = $request->descp;
        $rooms->availability        = $request->availability;
        $rooms->base_price          = $request->base_price;
        $mealDetails                = array();
        if($request->mealText):
            if(!empty($request->mealText)):
                foreach($request->mealText as $mpk => $mpkVal):
                    if(!empty($mpkVal) && !empty($request->mealValue[$mpk])):
                        $mealDetails[$request->mealValue[$mpk]] = $mpkVal;
                    endif;
                endforeach;
            endif;
        endif;
        $rooms->meal_details        = json_encode($mealDetails);
        $packageDetails             = array();
        if($request->packageText):
            if(!empty($request->packageText)):
                foreach($request->packageText as $mpk => $mpkVal):
                    if(!empty($mpkVal) && !empty($request->packageValue[$mpk])):
                        $packageDetails[$request->packageValue[$mpk]] = $mpkVal;
                    endif;
                endforeach;
            endif;
        endif;
        $rooms->package_details     = json_encode($packageDetails);
        $rooms->min_stay_policy     = $request->min_stay_policy;
        $rooms->inclusions          = $request->inclusions;
        $rooms->exclusions          = $request->exclusions;
        $cancPolicy                 = array();
        if($request->daysBeforeCheckIn):
            if(!empty($request->daysBeforeCheckIn)):
                foreach($request->daysBeforeCheckIn as $dbc => $dbcVal):
                    $cancPolicy[$dbcVal] = $request->deductPercentage[$dbc];
                endforeach;
            endif;
        endif;
        $rooms->cancellation_policy = json_encode($cancPolicy);
    	$rooms->save();
        $room_id = $rooms->id;
        for ($i=0; $i < count($request->amenities) ; $i++) :
           $roomsamenitie = new RoomsAmenitie;
           $roomsamenitie->room_id = $room_id;
           $roomsamenitie->amenities_id = $request->amenities[$i];
           $roomsamenitie->save();
        endfor;
        if(isset($request->gallery_image)):
            $gallery_images = $request->gallery_image;
            if(!empty($gallery_images)):
                for ($i=0; $i < count($gallery_images) ; $i++) :
                     $gallery_image = $request->file('gallery_image')[$i];
                     if($gallery_image):
                        $gallery_image      = time().$gallery_image->getClientOriginalName();
                        $request->gallery_image[$i]->move(public_path('uploads'), $gallery_image);
                        $data               = array();
                        $data['room_id']    = $room_id;
                        $data['image']      = $gallery_image;
                        $data['image_alt']  = $request->gallery_image_alt[$i];
                        RoomGallery::create($data);
                    endif;
                endfor;
            endif;
        endif;
        print json_encode(array('success' => true, 'message'=> 'Room Added Successfully !!!', 'swal' => 'success'));
    }
    public function rooms_edit($id){
        $rooms          = Rooms::where('id', '=', $id)->get()->first();
        $roomcategory   = RoomCategory::all();
        $amenities      = Amenities::all();
        $rooms_details  = RoomDetail::where('room_id', '=', $id)->get();
        $roomgallery    = RoomGallery::where('room_id', '=', $id)->get();
        $roomsamenitie  = RoomsAmenitie::where('room_id', '=', $id)->get();
        return view('frontend.hotelier.editroom', compact('id', 'rooms', 'roomcategory', 'rooms_details', 'roomgallery', 'amenities', 'roomsamenitie'));
    }
    public function hotelierDeleteGalleryImage(Request $request){
        $gld    =   RoomGallery::where('id', '=', $request->imgId)->get()->first();
        unlink(public_path('uploads/' . $gld->image));
        RoomGallery::where('id', '=', $request->imgId)->delete();
    }
    public function updateroom(Request $request, $id){
        $rooms                      = new Rooms;
    	$featured_image             = $request->file('featured_image');
    	$img                        = $request->old_featured_image;
        if($featured_image):
            $img                    = time().$featured_image->getClientOriginalName();
            $request->featured_image->move(public_path('uploads'), $img);
        endif;
        $rooms                      = Rooms::find($id);
        $rooms->featured_image      = $img;
    	$rooms->name                = $request->name;
    	$rooms->adult_capacity      = $request->adult_capacity;
    	$rooms->child_capacity      = $request->child_capacity;
        $rooms->room_capacity       = $request->room_capacity;
        $rooms->extra_bed           = $request->extra_bed;
        $rooms->descp               = $request->descp;
        $rooms->availability        = $request->availability;
        $rooms->base_price          = $request->base_price;
        $mealDetails                = array();
        if($request->mealText):
            if(!empty($request->mealText)):
                foreach($request->mealText as $mpk => $mpkVal):
                    if(!empty($mpkVal) && !empty($request->mealValue[$mpk])):
                        $mealDetails[$request->mealValue[$mpk]] = $mpkVal;
                    endif;
                endforeach;
            endif;
        endif;
        $rooms->meal_details        = json_encode($mealDetails);
        $packageDetails             = array();
        if($request->packageText):
            if(!empty($request->packageText)):
                foreach($request->packageText as $mpk => $mpkVal):
                    if(!empty($mpkVal) && !empty($request->packageValue[$mpk])):
                        $packageDetails[$request->packageValue[$mpk]] = $mpkVal;
                    endif;
                endforeach;
            endif;
        endif;
        $rooms->package_details     = json_encode($packageDetails);
        $rooms->min_stay_policy     = $request->min_stay_policy;
        $rooms->inclusions          = $request->inclusions;
        $rooms->exclusions          = $request->exclusions;
        $cancPolicy                 = array();
        if($request->daysBeforeCheckIn):
            if(!empty($request->daysBeforeCheckIn)):
                foreach($request->daysBeforeCheckIn as $dbc => $dbcVal):
                    $cancPolicy[$dbcVal] = $request->deductPercentage[$dbc];
                endforeach;
            endif;
        endif;
        $rooms->cancellation_policy = json_encode($cancPolicy);
    	$rooms->save();
        if(!empty($request->amenities)):
            RoomsAmenitie::where('room_id', '=', $id)->delete();
            for ($i=0; $i < count($request->amenities) ; $i++) :
                $roomsamenitie                  = new RoomsAmenitie;
                $roomsamenitie->room_id         = $id;
                $roomsamenitie->amenities_id    = $request->amenities[$i];
                $roomsamenitie->save();
            endfor;
        endif;
        if(isset($request->old_gallery_image_id)):
            foreach($request->old_gallery_image_id as $ogiiKey => $ogii):
                $gld            = RoomGallery::where('id', '=', $ogii)->get()->first();
                $gld->image_alt = $request->old_gallery_image_alt[$ogiiKey];
                $gld->save();
            endforeach;
        endif;
        if(isset($request->gallery_image)):
            $gallery_images = $request->gallery_image;
            if(!empty($gallery_images)):
                for ($i=0; $i < count($gallery_images) ; $i++) :
                     $gallery_image = $request->file('gallery_image')[$i];
                     if($gallery_image):
                        $gallery_image      = time().$gallery_image->getClientOriginalName();
                        $request->gallery_image[$i]->move(public_path('uploads'), $gallery_image);
                        $data               = array();
                        $data['room_id']    = $id;
                        $data['image']      = $gallery_image;
                        $data['image_alt']  = $request->gallery_image_alt[$i];
                        RoomGallery::create($data);
                    endif;
                endfor;
            endif;
        endif;
        print json_encode(array('success' => true, 'message'=> 'Room Details Updated Successfully !!!', 'swal' => 'success'));
    }
    
    
    
    
    
	public function rooms_doadd_back(Request $request, $id){
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
        $rooms->descp = $request->descp;
        $rooms->availability = $request->availability;
        $rooms->base_price = $request->base_price;
    	$rooms->save();
        $room_id = $rooms->id;
        for ($i=0; $i < count($request->amenities) ; $i++) { 
           $roomsamenitie = new RoomsAmenitie;
           $roomsamenitie->room_id = $room_id;
           $roomsamenitie->amenities_id = $request->amenities[$i];
           $roomsamenitie->save();
        }
        $get_data = Rooms::where('id', '=', $room_id)->get()->first();

        echo json_encode(array('success'=>true, 'form_no' => 1, 'message'=> 'Room Added successfully!', 'results' => $get_data));
        exit();
    }

    public function rooms_details_add(Request $request){
        $floor_no_arr =  $request->floor_no;
        for ($i=0; $i < count($floor_no_arr) ; $i++) { 
            $data['room_no'] = $request->room_no[$i];
            $data['floor_no'] = $request->floor_no[$i];
            $data['room_id'] = $request->room_id;
            $data['hotel_id'] = $request->hotel_id;
            $data['bed_count'] = $request->bed_count[$i];
            $data['availability'] = $request->{'availability_'.$i};
            RoomDetail::create($data);
        }
        $get_data = RoomDetail::where('room_id', '=', $request->room_id)->get()->first();
        $roomavailability = RoomAvailability::where('room_id', '=', $request->room_id)->get();
        $room_details = RoomDetail::where('room_id', '=', $request->room_id)->get();
        if(!empty($roomavailability)){
            foreach($roomavailability as $rk => $ra){
                foreach($room_details as $rdk => $rdV){
                    $roomallocation = new RoomAllocation;
                    $roomallocation->availability_id = $ra->id;
                    $roomallocation->room_details_id = $rdV->id;
                    $roomallocation->save();
                }
            }
        }
        echo json_encode(array('success'=>true, 'form_no' => 2,'message'=> 'Room Added successfully!', 'results' => $get_data));
        exit();
    }

    public function rooms_gallery_add(Request $request){
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

    

    public function updateroom_back(Request $request, $id){
        $rooms = Rooms::where('id', '=', $id)->get()->first();
        $rooms->name = $request->name;
        $rooms->adult_capacity = $request->adult_capacity;
        $rooms->child_capacity = $request->child_capacity;
        /*$rooms->room_capacity = $request->room_capacity;*/
        $rooms->category = $request->category;
        $rooms->extra_bed = $request->extra_bed;
        $rooms->base_price = $request->base_price;
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

    public function editetails(Request $request, $id){
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

    public function editgallery(Request $request, $id){
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
            //RoomGallery::where('room_id', '=', $id)->delete();
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

    public function price_rack($id){
        $price = Price::where('room_id', '=', $id)->get();
        return view('frontend.hotelier.price', compact('id', 'price'));
    }

    public function price_edit($id){
        $price_rack = PriceMatrix::where('price_id', '=', $id)->get();
        $Price = Price::where('id', '=', $id)->get();
        echo json_encode(array('price_rack' => $price_rack, 'price' => $Price));
    }

    public function addprice(Request $request, $id){
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

    public function addroomdate(Request $request){
        $date_from = strtotime($request->start);
        $date_to = strtotime($request->end);
        for ($i=$date_from; $i<=$date_to; $i+=86400) {
            //echo date("Y-m-d", $i).'<br />';
            if($id = RoomAvailability::where('room_id', '=', $request->room_id)->where('date', '=', date("Y-m-d", $i))->get()->first()['id']){
            $roomavailability = RoomAvailability::find($id);
            $roomavailability->availability = $request->title;
            $roomavailability->price = $request->price;
            }else{
            $roomavailability = new RoomAvailability;
            $roomavailability->date = date("Y-m-d", $i);
            $roomavailability->availability = $request->title;
            $roomavailability->hotel_id = $request->hotel_id;
            $roomavailability->room_id = $request->room_id;
            $roomavailability->availabe_rooms = $request->availabe_rooms;
            $roomavailability->price = $request->price;
            }
            $roomavailability->save();
        }
        echo json_encode(array('success'=>true,'message'=> 'date added successfully!'));
        exit;
    } 

    public function fetchRoomsdate(Request $request){
        $dates =  RoomAvailability::where('room_id', '=', $request->room_id)->get();
        $events = array();
        $data=array();
        foreach ($dates as $dt) {
                $data['id'] = $dt->id;
                $data['start'] =$dt->date;
                $data['end'] = $dt->date;
                $data['key'] = $dt->availability;
                $data['price'] = $dt->price;
                if($dt->availability=='1'){
                  $data['title'] = 'Available '.$dt->price;
                  $data['color'] = '#5cb85c;';
                }else if ($dt->availability=='2'){
                  $data['title'] = 'Unavailable';
                  $data['color'] = '#FF0000;';
                }else if ($dt->availability=='3') {
                      $data['title'] = 'Booked';
                      $data['color'] = '#d58512;';
                }else{
                  $data['title'] = 'Not define';
                  $data['color'] = '#CCC;';  
                }
                // $data['tips']=$rooms->name;
                array_push($events, $data); 
        }
         
        $response["events"]=$events;
        echo  json_encode($response);
        exit;
    }

    public function delprice($id){
        Price::where('id', $id)->delete();
        return redirect()->back()->with('message', 'price deleted successfully!');
    }
    public function delroom($id){
        Rooms::where('id', $id)->delete();
        RoomDetail::where('room_id', '=', $id)->delete();
        RoomGallery::where('room_id', '=', $id)->delete();
        return redirect()->back()->with('message', 'Room deleted successfully!');
    }
 
 public function delGalleryImage(Request $request){
        $gld=RoomGallery::where('id', '=', $request->key)->get()->first();
        Storage::Delete($gld->image);
        RoomGallery::where('id', '=', $request->key)->delete();
        $output = array('success' => 'Successfully Deleted' );
        echo json_encode($gld); 
     exit;
    }

    public function roomAvailable(Request $request){
        $user = auth('web')->user();
        $hotels = Hotels::where('user_id', '=', $user->id)->get()->first();
        $rooms = Rooms::where('hotel_id', '=',$hotels->id)->get();
        foreach ($rooms as $key => $room) {
           var_dump($room->id);
        }
    } 
    
}
