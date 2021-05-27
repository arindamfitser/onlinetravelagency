<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Admin;
use App\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Session\Store;

class AdminController extends Controller
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
        return view('admin.dashboard.index');
    }
    public function setlang(Request $request){
        $language = Input::get('locale'); //lang is name of form select field.
        \Session::put('language',$language);
        \App::setLocale($language);
    }
}
