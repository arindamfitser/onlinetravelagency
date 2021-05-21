<?php
namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Session;
class NewLoginPartController extends Controller{
    public function __construct(){
    }
    public function index(){
        return view('login-part.index');
    }
    public function saveUserType(Request $request){
        //session(['loginUserType' => $request->type]);
        Session::put('loginUserType', $request->type);
    }
    public function verifyHotelCode(){
        if(!session()->has('loginUserType')):
            header('Location: ' . filter_var(url('choose-type'), FILTER_SANITIZE_URL));
        else:
            if(Session::get('loginUserType') != 'Hotelier'):
                header('Location: ' . filter_var(url('choose-type'), FILTER_SANITIZE_URL));
            else:
                return view('login-part.verify-code');
            endif;
        endif;
    }
    public function verifyCode(Request $request){
        $check = DB::table('hotel_new_entries')->select('id', 'hotel_token')->where('hotel_token', $request->code)->first();
        if(!empty($check)):
            Session::put('codeVerified', $check->hotel_token);
            $response = array('success' => TRUE);
        else:
            $response = array('success' => FALSE);
        endif;
        print json_encode($response);
    }
}
