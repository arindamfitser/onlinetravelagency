<?php
namespace App\Http\Controllers;
use App\Review;
use App\Hotels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ReviewController extends Controller{
    public function index(){
        $user = auth('web')->user();
        $hotels = Hotels::where('user_id', '=', $user->id)->get();
        if($hotels):
            $dData = new \StdClass();
            foreach ($hotels as $key => $hValue) {
              $dData->hotelreviews[] = Review::where('hotel_id', '=' , $hValue->id)->where('status', '!=' , 3)->get();
            }
            return view('frontend.hotelier.reviews', compact('dData'));
        else:
            return abort(404);
        endif;
    }
    public function add_review(Request $request, $id){
    	$this->validate($request, [
            'subjects'  => 'required',
            'comment'   => 'required',
            'rating'    => 'required'
        ]);
        Review::create(array(
            'subjects'  => $request->subjects,
            'comments'  => $request->comment,
            'rating'    => $request->rating,
            'hotel_id'  => $id,
            'user_id'   => get_loggedin_id()
        ));
        $hotelreview    = Review::select('*')->where('hotel_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();
        $user_data      = get_user_details(get_loggedin_id());
        $html           = '';
        foreach($hotelreview as $hr):
            $user_data  = get_user_details($hr->user_id);
            $img        = (!empty($user_data->profile_image)) ? url('public/storage/uploads/profile/' . $user_data->profile_image) : url('/public/frontend/images/timthumb.jpg');
            $html .= '<div class="col-sm-3" style="min-height: 150px;">
        				<img src="'.$img.'" alt="'.$user_data->first_name.'" class="img-rounded" width="60" height="60"/>
    					<div class="review-block-name">'.$user_data->first_name .' '.$user_data->last_name .'</div>
    					<div class="review-block-date">'. date("d F, Y", strtotime($hr->created_at)) .'</div>
    				</div>
    				<div class="col-sm-9" style="min-height: 150px;">
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
        $review         = Review::find($id);
        $review->status = 1;
        $review->save();
        return redirect()->back();
    }
    public function delete($id){
        //Review::where('id', $id)->delete();
        $review         = Review::find($id);
        $review->status = 3;
        $review->save();
        return redirect()->back();
    }
}