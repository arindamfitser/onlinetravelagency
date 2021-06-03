<?php

namespace App\Http\Controllers;
use App\Hotels;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$user = auth('web')->user();
    	$hotels = Hotels::where('user_id', $user->id)->get();
    	if(!empty($hotels)){
            foreach($hotels as $hkey => $hdata){
               $transaction[] = Transaction::select('*', 'transactions.id as ts_id')->join('bookings', 'transactions.booking_id', '=', 'bookings.id')->where('bookings.hotel_id', '=', $hdata->id)->get();
            }
            return view('frontend.hotelier.transaction', compact('transaction'));
    	}else{
            abort(404);
        }

    }
}
