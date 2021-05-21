<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UsersController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = Admin::getAllUsers();
        $users = User::where('role', '=', "2")->get()->all();
        return view('admin.users.index', compact('users'));
    }

    public function hoteliers()
    {
        $users = User::where('role', '=', "1")->get()->all();
        return view('admin.users.index', compact('users'));
    }

     public function edit($username)
    {
        $user = User::where('id', '=', $username)->get()->first();
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::where('id', '=', $request->user_id)->get()->first();
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile_number  = $request->mobile_number;
        $user->country_code   = $request->country_code;
        $user->dob   = $request->dob ;
        $user->gender   = $request->gender ;
        $user->address  = $request->address ;
        if($user->save()){
           return redirect()->back()->with('message', 'User updated successfully!'); 
       }else{
           return redirect()->back()->with('message', ''); 
       }
        
        
        
    }


    public static function updateDetails(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|alpha|min:6|unique:users',
        ]);
        $user->update($request->all());
        return redirect()->route('admin.user.edit', $user->username);
    }


    public static function updatePassword(Request $request)
    {
        $user = User::where('id', '=', $request->user_id)->get()->first();
        $request->validate([
            'password' => 'required|alphanum|min:8|confirmed',
        ]);

        $user->update($request->all());
        session()->flash('success', 'Password successfully updates');
       return redirect()->back()->with('message', 'Password successfully updates'); 
    }

    public function del($id){
        User::where('id', $id)->delete();
        return redirect()->back()->with('message', 'User deleted successfully!');
    }

}
