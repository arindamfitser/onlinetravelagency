<?php

namespace App\Http\Controllers;
use App\Review;
use App\Hotels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ReviewController extends Controller
{
    public function index(){
        $user = auth('web')->user();
        $hotels = Hotels::where('user_id', '=', $user->id)->get()->all();
        if($hotels){
            $dData = new \StdClass();
            foreach ($hotels as $key => $hValue) {
              $dData->hotelreviews[] = Review::where('hotel_id', '=' , $hValue->id)->where('status', '!=' , 3)->get()->all();
            }
            return view('frontend.hotelier.reviews', compact('dData'));
        }else{
            return abort(404);
        }
    }

    public function add_review(Request $request, $id){
    	$this->validate($request, [
            'subjects'  => 'required',
            'comment'   => 'required',
            'rating'    => 'required'
        ]);
        DB::table('hotel_reviews')->insert([
            'subjects'  => $request->subjects,
            'comments'  => $request->comment,
            'rating'    => $request->rating,
            'hotel_id'  => $id,
            'user_id'   => get_loggedin_id(),
        ]);
        $hotelreview        = DB::table('hotel_reviews')->select('*')->where('hotel_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();
        $user_data  = get_user_details(get_loggedin_id());
        $img        = url('/public/frontend/images/timthumb.jpg');
        if($user_data->profile_image!=""):
            if(file_exists(Storage::disk('local')->url($user_data->profile_image))):
                $img    = Storage::disk('local')->url($user_data->profile_image);
            endif;
        endif;
        $html = '';
        foreach($hotelreview as $hr):
            $html .= '<div class="col-sm-3">
        				<img src="'.$img.'" alt="'.$user_data->first_name.'" class="img-rounded" width="60" height="60"/>
    					<div class="review-block-name">'.$user_data->first_name .' '.$user_data->last_name .'</div>
    					<div class="review-block-date">'. date("d F, Y", strtotime($hr->created_at)) .'</div>
    				</div>
    				<div class="col-sm-9">
    					<div class="review-block-rate">';
    					for($a = 1; $a <= 5 ; $a++ ):
    					    if($a <= $hr->rating):
    		$html .= '		    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
    							    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
    							</button>';
    						else:
    		$html .= '		    <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
    							    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
    							</button>';
    						endif;
    					endfor;
    		$html .= '	</div>
    					<div class="review-block-title">'.$hr->subjects.'</div>
    					<div class="review-block-description">'.$hr->comments.'</div>
    				</div>';
	    endforeach;
        echo json_encode(array('status' => TRUE, 'html' => $html));
    }
    public function review_status_change($id){
        $review = Review::find($id);
        $review->status = 1;
        $review->save();
        return redirect()->back();
    }
    public function delete($id){
        Review::where('id', $id)->delete();
        return redirect()->back();
    }

}
