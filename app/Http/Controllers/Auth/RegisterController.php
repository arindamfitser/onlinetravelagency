<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(!session()->has('loginUserType')):
            header('Location: ' . filter_var(url('choose-type'), FILTER_SANITIZE_URL));
            die;
        else:
            $this->middleware('guest');
        endif;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'fisrt_name' => 'required|alpha|max:255',
            'last_name' => 'required|alpha|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:7',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data){
        $user = User::create([
            'username' =>get_randompass(8),
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' =>  $data['last_name'],
            'password' => bcrypt($data['password']),
        ]);
        if (is_live()){
            $e_data = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ];
            Mail::send('emails.welcome', ['e_data' => $e_data], function ($m) use ($e_data) {
                $m->from('no-reply@fitser.com', 'Online Travel agency');
                $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Welcome to Guptahotels');
            });
        }
        // Redirect to route
        return redirect()->route('home');
    }

    protected function doCreate(Request $request){
        if($request->hotel_token):
            $check = DB::table('temp_direct_contract')->select('id')->where('hotel_code', $request->hotel_token)->get()->first();
            if(!empty($check)):
                $check = DB::table('users')->select('id')->where('hotel_token', $request->hotel_token)->get()->first();
                if(empty($check)):
                    $check = DB::table('users')->select('id')->where('email', $request->email)->get()->first();
                    if(empty($check)):
                        $insertArray        = array(
                            'username'      => get_randompass(8),
                            'email'         => $request->email,
                            'first_name'    => $request->first_name,
                            'last_name'     =>  $request->last_name,
                            'password'      => bcrypt($request->password),
                            'country_code'  => $request->country_code,
                            'role'          => '1',
                            'hotel_token'   => $request->hotel_token
                        );
                        $insertId = DB::table('users')->insertGetId($insertArray);
                        DB::table('hotel_new_entries')
                            ->where('hotel_token', $request->hotel_token)
                            ->update(array('user_id' => $insertId));
                        if (is_live()):
                            /*$e_data = [
                                'first_name'    => $request->first_name,
                                'last_name'     => $request->last_name,
                                'email'         => $request->email,
                                'password'      => $request->password,
                            ];
                            Mail::send('emails.welcome', ['e_data' => $e_data], function ($m) use ($e_data) {
                                $m->from('no-reply@fitser.com', 'Luxury Fishing');
                                $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Welcome to Luxury Fishing');
                            });*/
                        endif;
                        $response = array(
                            'success'   => TRUE,
                            'message'   => 'Profile Created Successfully !!!',
                            'swal'      => 'success'
                        );
                    else:
                        $response = array(
                            'success'   => FALSE,
                            'message'   => 'Account Already Registered with this Email !!!',
                            'swal'      => 'warning'
                        );
                    endif;
                else:
                    $response = array(
                        'success'   => FALSE,
                        'message'   => 'Account Already Registered with this Hotel Token !!!',
                        'swal'      => 'warning'
                    );
                endif;
            else:
                $response = array(
                    'success'   => FALSE,
                    'message'   => 'No Such Hotel Token Found !!!',
                    'swal'      => 'error'
                );
            endif;
        else:
            $check = DB::table('users')->select('id')->where('email', $request->email)->where('role !=', '3')->get()->first();
            if(empty($check)):
                $user = User::create([
                    'username'      => get_randompass(8),
                    'email'         => $request->email,
                    'first_name'    => $request->first_name,
                    'last_name'     =>  $request->last_name,
                    'password'      => bcrypt($request->password),
                    'country_code'  => $request->country_code,
                ]);
                // $db_conn = DB::connection('mysql2');
                // $db_conn->table('ota_users')->insert(['user_login' => $request->email, 'user_pass' => md5($request->password), 'user_registered' => date('Y-m-d H:i:s'), 'user_nicename' => $request->first_name, 'user_email' => $request->email, 'display_name' => $request->email]);
                // $wp_user = $db_conn->table('ota_users')->select('ID')->where('user_login', '=', $request->email)->get()->first();
                // $db_conn->table('ota_usermeta')->insert(['user_id' => $wp_user->ID, 'meta_key' => 'ota_capabilities', 'meta_value' => 'a:1:{s:6:"author";b:1;}']);
                if (is_live()):
                    $e_data = [
                        'first_name'    => $request->first_name,
                        'last_name'     => $request->last_name,
                        'email'         => $request->email,
                        'password'      => $request->password,
                    ];
                    Mail::send('emails.welcome', ['e_data' => $e_data], function ($m) use ($e_data) {
                        $m->from('no-reply@fitser.com', 'Luxury Fishing');
                        $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Welcome to Luxury Fishing');
                    });
                endif;
            else:
                $response = array(
                    'success'   => FALSE,
                    'message'   => 'Account Already Registered with this Email !!!',
                    'swal'      => 'warning'
                );
            endif;
        endif;
        print json_encode($response);
    }
}
