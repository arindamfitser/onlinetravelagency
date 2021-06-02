<?php
namespace App\Http\Controllers\Ajax;
use App\User;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }
    public function DoUpdateProfile(Request $request){
        $U                      = auth('web')->user(); 
        $user                   = User::find($U->id);
        $user->first_name       = $request->first_name;
        $user->last_name        = $request->last_name;
        $user->mobile_number    = $request->mobile_number;
        $user->address          = $request->address;
        $user->country_code     = $request->country_code;
        $user->dob              = $request->dob;
        $user->gender           = $request->gender;
        if($user->save()):
            $response = array(
                'success'   => TRUE,
                'message'   => 'Profile Updated Successfully !!!',
                'swal'      => 'success',
            );
        else:
            $response = array(
                'success'   => False,
                'message'   => 'Something Went Wrong !!!  Please Try Again !!!',
                'swal'      => 'warning',
            );
        endif;
        print json_encode($response);
    }
    public function DoChangePassword(Request $request){
        $U = auth('web')->user();
        $user           = User::find($U->id);
        $user->password = bcrypt($request->password);
        if($user->save()):
            $response = array(
                'success'   => TRUE,
                'message'   => 'Password Updated Successfully !!!',
                'swal'      => 'success',
            );
        else:
            $response = array(
                'success'   => False,
                'message'   => 'Something Went Wrong !!!  Please Try Again !!!',
                'swal'      => 'warning',
            );
        endif;
        print json_encode($response);
    }
    public function DoUpdateProfileHotelier(Request $request){
        $U                      = auth('web')->user();  
        $user                   = User::find($U->id);
        $user->title            = $request->title;
        $user->first_name       = $request->first_name;
        $user->last_name        = $request->last_name;
        $user->mobile_number    = $request->mobile_number;
        $user->address          = $request->address;
        $user->country_code     = $request->country_code;
        $user->personal_email   = $request->personal_email;
        $user->job_title        = $request->job_title;
        if($user->save()):
            $response = array(
                'success'   => TRUE,
                'message'   => 'Profile Updated Successfully !!!',
                'swal'      => 'success',
            );
        else:
            $response = array(
                'success'   => False,
                'message'   => 'Something Went Wrong !!!  Please Try Again !!!',
                'swal'      => 'warning',
            );
        endif;
        print json_encode($response);
    }
    public function DoChangePasswordHotelier(Request $request){
        $U = auth('web')->user();
        $user           = User::find($U->id);
        $user->password = bcrypt($request->password);
        if($user->save()):
            $response = array(
                'success'   => TRUE,
                'message'   => 'Password Updated Successfully !!!',
                'swal'      => 'success',
            );
        else:
            $response = array(
                'success'   => False,
                'message'   => 'Something Went Wrong !!!  Please Try Again !!!',
                'swal'      => 'warning',
            );
        endif;
        print json_encode($response);
    }
    public function ajaxImage(Request $request){
        $U = auth('web')->user();  
        if ($request->isMethod('get')) :
            return view('ajax_image_upload');
        else :
            $validator = Validator::make($request->all(),
            [
                'file' => 'image',
            ],
            [
                'file.image' => 'The file must be an image (jpeg, png, bmp, gif, or svg)'
            ]);
            if ($validator->fails()):
                return array(
                    'fail' => true,
                    'errors' => $validator->errors()
                );
            endif;
            $profile_image              = $request->file('file');
            if($profile_image):
                $img                    = time().$profile_image->getClientOriginalName();
                $request->file->move(public_path('storage/uploads/profile'), $img);
            endif;
            if($profile_image):
                $user                   = User::find($U->id);
                $user->profile_image    = $img;
                $user->save();
            endif;
            return url('public/storage/uploads/profile/' . $img);
        endif;
    }
    public function deleteImage(Request $request){
        $U = auth('web')->user();
        $filename = $request->filename;  
        $user = User::find($U->id);
        $user->profile_image ="" ;
        if($user->save()){
             Storage::delete($filename);
          //File::delete($filename);
        }
    }
}
