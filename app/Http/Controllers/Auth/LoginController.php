<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        if(!session()->has('loginUserType')):
            header('Location: ' . filter_var(url('choose-type'), FILTER_SANITIZE_URL));
            die;
        else:
            // echo "<pre>";
            // print_r(session()->all());
            // die;
            // if(Session::get('loginUserType') == 'Hotelier' && !session()->has('codeVerified')):
            //     header('Location: ' . filter_var(url('choose-type'), FILTER_SANITIZE_URL));
            //     die;
            // else:
                if(session()->has('codeVerified')):
                    Session::forget('codeVerified');
                endif;
                $this->middleware('guest:web')->except('logout', 'userLogout'); 
            //endif;
        endif;
     }
    public function userLogout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }
    // This works
    protected function guard() {
        return Auth::guard('web');
    }    
}
