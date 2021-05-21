<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HotelsTranslation;
use App\HotelCommission;
use App\Hotels;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = HotelsTranslation::join('hotel_commissions', 'hotels_translations.hotels_id', '=', 'hotel_commissions.hotel_id')->get()->all();
        if(empty($hotels)){
            $hotels = Hotels::all();
        }
        return view('admin.commissions.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        /*print_r($request->all());
        exit();*/
        $hotel_ids = $request->hotel_ids;
        $commissions = $request->commissions;
        for ($i=0; $i < count($hotel_ids) ; $i++) { 
               $hotel_id = $hotel_ids[$i];
               $commission = $commissions[$i];
               $hotelcommission = HotelCommission::where('hotel_id', '=', $hotel_id)->get()->first();
               if($hotelcommission){
                    $hotelcommission->commission = $commission;
                    $hotelcommission->save();
               }else{
                    $hotelcommission = new HotelCommission;
                    $hotelcommission->hotel_id = $hotel_id;
                    $hotelcommission->commission = $commission;
                    $hotelcommission->save();
            }
        }
        return redirect()->back()->with('message', 'Commission updated successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
