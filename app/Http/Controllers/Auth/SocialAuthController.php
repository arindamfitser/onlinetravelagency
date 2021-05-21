<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * List of providers configured in config/services acts as whitelist
     *
     * @var array
     */
    protected $providers = [
        'github',
        'facebook',
        'google',
        'twitter'
    ];

    /**
     * Show the social login page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Redirect to provider for authentication
     *
     * @param $driver
     * @return mixed
     */
    public function redirectToProvider($driver)
    {
        if( ! $this->isProviderAllowed($driver) ) {
            //return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    /**
     * Handle response of authentication redirect callback
     *
     * @param $driver
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback( $driver )
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty( $user->email )
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    /**
     * Send a successful response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendSuccessResponse()
    {
        return redirect()->intended('home');
    }

    /**
     * Send a failed response with a msg
     *
     * @param null $msg
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('social.login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
     
        $user = User::where('email', $providerUser->getEmail())->first();

        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
            $user->update([
                'profile_image ' => $providerUser->avatar,
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token
             ]);
        } else {
            $userdata= $providerUser->user;
            if($driver=='facebook'){
                $name = explode(' ', $userdata['name']);
                $first_name = $name[0] ;
                $last_name = $name[1];
            }else{
                $first_name = $userdata['given_name'];
                $last_name = $userdata['family_name'];
            }
            // create a new user
            $user = User::create([
                    'username' => get_randompass(8),
                    'first_name' =>$first_name,
                    'last_name' =>$last_name,
                    'email' => $providerUser->getEmail(),
                    'password' => ''
                ]);

            $user->profile_image = $providerUser->getAvatar();
            $user->provider = $driver;
            $user->role = 2;
            $user->provider_id = $providerUser->getId();
            $user->access_token = $providerUser->token;
            $user->save();
            $db_conn = DB::connection('mysql2');
            $db_conn->table('ota_users')->insert(['user_login' => $providerUser->getEmail(), 'user_pass' => md5(123456), 'user_registered' => date('Y-m-d H:i:s'), 'user_nicename' => $first_name, 'user_email' => $providerUser->getEmail(), 'display_name' => $providerUser->getEmail()]);
            $wp_user = $db_conn->table('ota_users')->select('ID')->where('user_login', '=', $providerUser->getEmail())->get()->first();
            $db_conn->table('ota_usermeta')->insert(['user_id' => $wp_user->ID, 'meta_key' => 'ota_capabilities', 'meta_value' => 'a:1:{s:6:"author";b:1;}']);
             if (is_live()){
                $e_data = [
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'password' => 'Your login from '.$user->provider,
                      ];
                  Mail::send('emails.welcome', ['e_data' => $e_data], function ($m) use ($e_data) {
                      $m->from('no-reply@fitser.com', 'Online Travel agency');

                       $m->to($e_data['email'], $e_data['first_name'].' '.$e_data['last_name'])->subject('Welcome to Guptahotels');
                  });
              }
        }
        // login the user
        Auth::login($user, true);
        return $this->sendSuccessResponse();
    }

    /**
     * Check for provider allowed and services configured
     *
     * @param $driver
     * @return bool
     */
    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}