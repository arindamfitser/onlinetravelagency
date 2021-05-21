<?php

namespace App;
use App\Filter;
use App\Hotels;
use App\Countries;
use App\Regions;
use App\States;
use App\Species;
use App\Accommodations;
use App\Inspirations;
use App\Experiences;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Facades\DB;
use Session;
class Filter extends Model
{
   
   public function search (){
   	echo 'cczxcxzc';
   }

   public function parce_kayword($keywords){
    $lang='en';
    $data = array();
   	$keys = explode(',', $keywords);
   	foreach ($keys as $key => $keyword) {

       if(!empty(@Hotels::whereTranslationLike('hotels_name', '%'.$keyword.'%')->first()->id)){
           $hotels= @Hotels::whereTranslationLike('hotels_name', '%'.$keyword.'%')
                            ->where('status', '=', '1')
                            ->get()->all();
            if(!empty($hotels)){
              foreach ($hotels as $key => $hotel) {
                array_push($data, $hotel);
             }
           }
          
       } 

   		 if(!empty(@Hotels::where('town', 'like', "%{$keyword}%")->get())){
   		 	  $hotels=@Hotels::where('town', 'like', "%{$keyword}%")
                          ->where('status', '=', '1')
                          ->orderBy('curator_rating', 'desc')
                          ->get()->all();
          
   		 	   if(!empty($hotels)){
            foreach ($hotels as $key => $hotel) {
               array_push($data, $hotel);
            }
          }
          
   		 }   
   		 
       if(@Countries::whereTranslationLike('countries_name', '%'.$keyword.'%')->first()->id){
   		 	    $coutry_id=@Countries::whereTranslationLike('countries_name', '%'.$keyword.'%')->first()->id;
            $hotels = Hotels::where('country_id', '=' , $coutry_id)
                              ->where('status', '=', '1')
                              ->orderBy('curator_rating', 'desc')
                              ->get()->all();
               
            if(!empty($hotels)){
            foreach ($hotels as $key => $hotel) {
              array_push($data, $hotel);
            }
          }
   		 }  
      
       if(@Regions::whereTranslationLike('regions_name', '%'.$keyword.'%')->first()->id){
   		 	    $region_id=@Regions::whereTranslationLike('regions_name', '%'.$keyword.'%')->first()->id;
            $hotels = Hotels::where('region_id', '=' , $region_id)
                              ->where('status', '=', '1')
                              ->orderBy('curator_rating', 'desc')
                              ->get()->all();
             if(!empty($hotels)){
              foreach ($hotels as $key => $hotel) {
                 array_push($data, $hotel);
              }
          }
   		 }

   		 if(@States::whereTranslationLike('states_name', '%'.$keyword.'%')->first()->id){
   		 	  $state_id=@States::whereTranslationLike('states_name', '%'.$keyword.'%')->first()->id;
            $hotels = Hotels::where('state_id', '=' , $state_id)
                              ->where('status', '=', '1')
                              ->orderBy('curator_rating', 'desc')
                              ->get()->all();
            if(!empty($hotels)){
              foreach ($hotels as $key => $hotel) {
                 array_push($data, $hotel);
              }
           }  
       }

   		 if(@Species::whereTranslationLike('species_name', '%'.$keyword.'%')->first()->id){
   		 	   $species_id=@States::whereTranslationLike('states_name', '%'.$keyword.'%')->first()->id;
           $hotels = Hotels::join('hotel_species_relations', 'hotel_species_relations.hotel_id', '=', 'hotels.id')
                            ->join('hotels_translations', 'hotels_translations.hotels_id', '=', 'hotels.id')
                            ->where('hotel_species_relations.species_id', '=', $species_id)
                            ->where('hotels_translations.locale', '=', 'en')
                            ->where('hotels.status', '=', '1')
                            ->orderBy('hotels.curator_rating', 'desc')
                            ->get()->all();
            if(!empty($hotels)){
              foreach ($hotels as $key => $hotel) {
                 array_push($data, $hotel);
              }
           }
   		 }

   		 if(@Accommodations::whereTranslationLike('accommodations_name', '%'.$keyword.'%')->first()->id){
   		 	 $accommodations_id=@Accommodations::whereTranslationLike('accommodations_name', '%'.$keyword.'%')->first()->id;
         $hotels = Hotels::join('hotel_accommodation_relations', 'hotel_accommodation_relations.hotel_id', '=', 'hotels.id')
                          ->join('hotels_translations', 'hotels_translations.hotels_id', '=', 'hotels.id')
                          ->where('hotel_accommodation_relations.accommodation_id', '=', $accommodations_id)
                          ->where('hotels_translations.locale', '=', 'en')
                          ->where('hotels.status', '=', '1')
                          ->orderBy('hotels.curator_rating', 'desc')
                          ->get()->all(); 
          if(!empty($hotels)){
              foreach ($hotels as $key => $hotel) {
                 array_push($data, $hotel);
              }
           }
   		 }
       
      if(@Inspirations::whereTranslationLike('inspirations_name', '%'.$keyword.'%')->first()->id){
   		 	 $inspirations_id=@Inspirations::whereTranslationLike('inspirations_name', '%'.$keyword.'%')->first()->id;
         $hotels = Hotels::join('hotel_inspirations_relations', 'hotel_inspirations_relations.hotel_id', '=', 'hotels.id')
                        ->join('hotels_translations', 'hotels_translations.hotels_id', '=', 'hotels.id')
                        ->where('hotel_inspirations_relations.inspirations_id', '=', $inspirations_id)
                        ->where('hotels_translations.locale', '=', 'en')
                        ->where('hotels.status', '=', '1')
                        ->orderBy('hotels.curator_rating', 'desc')
                        ->get()->all();
            if(!empty($hotels)){
              foreach ($hotels as $key => $hotel) {
                 array_push($data, $hotel);
              }
           }
   		 }

      if(@Experiences::whereTranslationLike('experiences_name', '%'.$keyword.'%')->first()->id){
   		   	$experiences_id=@Experiences::whereTranslationLike('experiences_name', '%'.$keyword.'%')->first()->id;
          $hotels = Hotels::join('hotel_experiences_relations', 'hotel_experiences_relations.hotel_id', '=', 'hotels.id')
                            ->join('hotels_translations', 'hotels_translations.hotels_id', '=', 'hotels.id')
                            ->where('hotel_experiences_relations.experiences_id', '=', $experiences_id)
                            ->where('hotels_translations.locale', '=', 'en')
                            ->where('hotels.status', '=', '1')
                            ->orderBy('hotels.curator_rating', 'desc')
                            ->get()->all();
            if(!empty($hotels)){
              foreach ($hotels as $key => $hotel) {
                 array_push($data, $hotel);
              }
           }
   		   }
   	  }
     
   	 return array_unique($data, SORT_REGULAR);
   }
  public function fatchRoomsxml($url,$xml){
    //setting the curl parameters.
    $ch = curl_init();
    //header('Content-type: text/xml');
    //echo $xml; die;
    curl_setopt($ch, CURLOPT_URL, $url);
    // Following line is compulsary to add as it is:
    curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);        
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30000);
    $data = curl_exec($ch);
    //print_r($data); die;
    curl_close($ch);
    if ($data) {
      //convert the XML result into array
      $results = json_decode(json_encode(simplexml_load_string($data)), true);
      return  $results;
    }else{
      return $data;
    }
  }
  public function HotelDetailXML($hotelid){
    $new_fileName= $hotelid.'.xml';
    $oldfileexists =  asset('hoteldetailxml/'.$new_fileName);
    //$xml = XmlParser::extract($oldfileexists); 
    $xmlfile = file_get_contents($oldfileexists);
    $ob= simplexml_load_string($xmlfile);
    $json  = json_encode($ob);
    $configData = json_decode($json, true);
    var_dump($configData );
  }
  public function AvailabilitySearchXML($request){
    //var_dump($request->all());
    //exit;
    $adults=explode(' ', $request->quantity_adults);
    $childs=explode(' ', $request->quantity_child);
    //$rooms=explode(' ', $request->quantity_rooms);
    $rooms=$request->ab;
    $start = $request->t_start;
    $end = $request->t_end;
    $nights = dateDiff($start, $end);
    $region = $request->region_id;
    $xml = '<AvailabilitySearch xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
    $xml .= '<Authority xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
    $xml .= '<Org>'.get_option('authority_org').'</Org>';
    $xml .= '<User>'.get_option('authority_user').'</User>';
    $xml .= '<Password>'.get_option('authority_password').'</Password>';
    $xml .= '<Currency>AUD</Currency>';
    $xml .= '<Language>en</Language>';
    $xml .= '<TestDebug>false</TestDebug>';
    $xml .= '<Version>1.28</Version>';
    $xml .= '</Authority>';
    $xml .= '<RegionId>'.$region.'</RegionId>';
    $xml .= '<HotelStayDetails>';
    $xml .= '<ArrivalDate>'.$start.'</ArrivalDate>';
    $xml .= '<Nights>'.$nights.'</Nights>';
    $xml .= '<Nationality>GB</Nationality>';
    foreach($rooms["norm"] as $k=>$val){
      $xml .= '<Room>';
      $xml .= '<Guests>';
      if($rooms["adlts"][$k]>0){
        for ($i=0; $i <$rooms["adlts"][$k] ; $i++) { 
          $xml .= ' <Adult />';
        }
      }
      if($rooms["kids"][$k]>0){
        for ($j=0; $j <$rooms["kids"][$k] ; $j++) { 
          $xml .= '<Child age="5" />';
        } 
      }
      $xml .= '</Guests>';
      $xml .= '</Room>';
    }
    $xml .= '</HotelStayDetails>';
    $xml .= '<HotelSearchCriteria>';
    $xml .= '<AvailabilityStatus>allocation</AvailabilityStatus>';
    $xml .= '</HotelSearchCriteria>';
    $xml .= ' <DetailLevel>full</DetailLevel>';
    $xml .= '</AvailabilitySearch>';
    return $xml ;       
  }
  public function BookingXML($request){
        $xml = '<BookingCreate xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
        $xml .= '<Authority xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
        $xml .= '<Org>'.get_option('authority_org').'</Org>';
        $xml .= '<User>'.get_option('authority_user').'</User>';
        $xml .= '<Password>'.get_option('authority_password').'</Password>';
        $xml .= '<Language>en</Language>';
        $xml .= '<Currency>AUD</Currency>';
        $xml .= '<TestDebug>false</TestDebug>';
        $xml .= '<Version>1.28</Version>';
        $xml .= '</Authority>';
        $xml .= '<QuoteId>'.$request->quoteid.'</QuoteId>';
        $xml .= '<HotelStayDetails>';
        $xml .= '<Room>';
        $xml .= '<Guests>';
        for ($i=0; $i < $request->quantity_adults ; $i++) { 
          $xml .= '<Adult title="'.$request->title[$i].'" first="'.$request->first[$i].'" last="'.$request->last[$i].'">';
          $xml .= '</Adult>';
        }
        $xml .= '</Guests>';
        $xml .= '</Room>';
        $xml .= '</HotelStayDetails>';
        $xml .= '<HotelSearchCriteria>';
        $xml .= '<AvailabilityStatus>allocation</AvailabilityStatus>';
        $xml .= '<DetailLevel>basic</DetailLevel>';
        $xml .= '</HotelSearchCriteria>';
        $xml .= '<CommitLevel>prepare</CommitLevel>';
        $xml .= '</BookingCreate>';

        return $xml ;       
  }
  public function BookingPrepareXMLNew($request){
    // echo "<pre>";
    // print_r($request);
    // exit;
    ini_set('max_execution_time', 180); //3 minutes
      $xml = '<BookingCreate xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
      $xml .= '<Authority xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
      $xml .= '<Org>'.get_option('authority_org').'</Org>';
      $xml .= '<User>'.get_option('authority_user').'</User>';
      $xml .= '<Password>'.get_option('authority_password').'</Password>';
      $xml .= '<Language>en</Language>';
      $xml .= '<Currency>AUD</Currency>';
      $xml .= '<TestDebug>false</TestDebug>';
      $xml .= '<Version>1.28</Version>';
      $xml .= '</Authority>';
      $xml .= '<QuoteId>'.$request['quoteid'].'</QuoteId>';
      $xml .= '<HotelStayDetails>';
      foreach($request['room'] as $key => $room){
          $xml .= '<Room>';
              $xml .= '<Guests>';
            if(!empty($room['adult'])){
                  foreach($room['adult'] as $key1=> $audlt){
                        $xml .= '<Adult title="'.$audlt['title'].'" first="'.$audlt['first'].'" last="'.$audlt['last'].'">';
                        $xml .= '</Adult>';
                  }
              }
            if(!empty($room['child'])){
                  foreach($room['child'] as $key2=>$child){
                      $xml .= '<Child  age="'.$child['age'].'"  title="'.$child['title'].'" first="'.$child['first'].'" last="'.$child['last'].'"/>';
                  }
              }
              $xml .= '</Guests>';
          $xml .= '</Room>';
      }
      $xml .= '</HotelStayDetails>';
      $xml .= '<HotelSearchCriteria>';
      $xml .= '<AvailabilityStatus>allocation</AvailabilityStatus>';
      $xml .= '<DetailLevel>basic</DetailLevel>';
      $xml .= '</HotelSearchCriteria>';
      $xml .= '<CommitLevel>prepare</CommitLevel>';
      $xml .= '</BookingCreate>';
      return $xml; 
  }
  public function BookingPrepareXML($request){
      ini_set('max_execution_time', 180); //3 minutes
        $xml = '<BookingCreate xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
        $xml .= '<Authority xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
        $xml .= '<Org>'.get_option('authority_org').'</Org>';
        $xml .= '<User>'.get_option('authority_user').'</User>';
        $xml .= '<Password>'.get_option('authority_password').'</Password>';
        $xml .= '<Language>en</Language>';
        $xml .= '<Currency>AUD</Currency>';
        $xml .= '<TestDebug>false</TestDebug>';
        $xml .= '<Version>1.28</Version>';
        $xml .= '</Authority>';
        $xml .= '<QuoteId>'.$request->quoteid.'</QuoteId>';
        $xml .= '<HotelStayDetails>';
        foreach($request->room as $key=>$room){ 
            $xml .= '<Room>';
                $xml .= '<Guests>';
              if(!empty($room['audlt'])){
                    foreach($room['audlt'] as $key1=>$audlt){
                          $xml .= '<Adult title="'.$audlt['title'].'" first="'.$audlt['first'].'" last="'.$audlt['last'].'">';
                          $xml .= '</Adult>';
                    }
                }
                
              if(!empty($room['child'])){
                    foreach($room['child'] as $key2=>$child){
                        $xml .= '<Child  age="'.$child['age'].'"  title="'.$child['title'].'" first="'.$child['first'].'" last="'.$child['last'].'"/>';
                    }
                }
                $xml .= '</Guests>';
            $xml .= '</Room>';
        }
        $xml .= '</HotelStayDetails>';
        $xml .= '<HotelSearchCriteria>';
        $xml .= '<AvailabilityStatus>allocation</AvailabilityStatus>';
        $xml .= '<DetailLevel>basic</DetailLevel>';
        $xml .= '</HotelSearchCriteria>';
        $xml .= '<CommitLevel>prepare</CommitLevel>';
        $xml .= '</BookingCreate>';

        return $xml ; 
        //var_dump($xml);
        //exit;
  }
  public function BookingConfirmXML($request){
    ini_set('max_execution_time', 180); //3 minutes
    $xml = '<BookingCreate xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
    $xml .= '<Authority xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
    $xml .= '<Org>'.get_option('authority_org').'</Org>';
    $xml .= '<User>'.get_option('authority_user').'</User>';
    $xml .= '<Password>'.get_option('authority_password').'</Password>';
    $xml .= '<Language>en</Language>';
    $xml .= '<Currency>AUD</Currency>';
    $xml .= '<TestDebug>false</TestDebug>';
    $xml .= '<Version>1.28</Version>';
    $xml .= '</Authority>';
    $xml .= '<QuoteId>'.$request->quoteid.'</QuoteId>';
    $xml .= '<HotelStayDetails>';
      foreach($request->room as $key=>$room){ 
            $xml .= '<Room>';
                $xml .= '<Guests>';
              if(!empty($room['audlt'])){
                    foreach($room['audlt'] as $key=>$audlt){
                          $xml .= '<Adult title="'.$audlt['title'].'" first="'.$audlt['first'].'" last="'.$audlt['last'].'">';
                          $xml .= '</Adult>';
                    }
                }
                
              if(!empty($room['child'])){
                    foreach($room['child'] as $key=>$child){
                        $xml .= '<Child  age="'.$child['age'].'"  title="'.$child['title'].'" first="'.$child['first'].'" last="'.$child['last'].'"/>';
                    }
                }
                $xml .= '</Guests>';
            $xml .= '</Room>';
        }
    $xml .= '</HotelStayDetails>';
    $xml .= '<HotelSearchCriteria>';
    $xml .= '<AvailabilityStatus>allocation</AvailabilityStatus>';
    $xml .= '<DetailLevel>basic</DetailLevel>';
    $xml .= '</HotelSearchCriteria>';
    $xml .= '<CommitLevel>confirm</CommitLevel>';
    $xml .= '</BookingCreate>';

        return $xml ;       
  }
  /*public function get_xml_hotel_details($hotelid){
    ini_set('memory_limit','1536M'); // 1.5 GB
    ini_set('max_execution_time', 18000); // 5 hours
    $new_fileName= $hotelid.'.xml';
    $xmlfile =  asset('hoteldetailxml/'.$new_fileName);
    $xmlcontent = file_get_contents($xmlfile);
    $ob= simplexml_load_string($xmlcontent);
    $json  = json_encode($ob);
    $configData = json_decode($json, true);
    var_dump($configData );
    
  }*/
  public function get_xml_hotel_details($hotelid){
    $hotels = DB::table('hotel_master_xml')->join('hotel_description_xml', 'hotel_master_xml.id', '=', 'hotel_description_xml.hotel_id')->join('hotel_address_xml', 'hotel_master_xml.id', '=', 'hotel_address_xml.hotel_id')->where('hotel_master_xml.id', $hotelid)->get()->first();
    $hotelDesc = DB::table('hotel_description_xml')->where('hotel_id', $hotelid)->get();
    $images = DB::table('hotel_images_xml')->select('*')->where('hotel_images_xml.hotel_id', $hotelid)->get();
    $amenity = DB::table('hotel_amenity_xml')->select('Text')->where('hotel_amenity_xml.hotel_id', $hotelid)->get();
    $address = DB::table('hotel_address_xml')->select('*')->where('hotel_address_xml.hotel_id', $hotelid)->get();
    $dataArray = array('hotels' => $hotels, 'images' => $images, 'amenity' => $amenity, 'address' => $address, 'hotelDesc' => $hotelDesc);
    return $dataArray;
  }
  public function BookingCancelPrepareXML($BookingId){
    ini_set('max_execution_time', 180); //3 minutes
    $xml = '<BookingCancel xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
      $xml .= '<Authority xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
          $xml .= '<Org>testrht</Org>';
          $xml .= '<Org>'.get_option('authority_org').'</Org>';
          $xml .= '<User>'.get_option('authority_user').'</User>';
          $xml .= '<Password>'.get_option('authority_password').'</Password>';
          $xml .= '<Currency>AUD</Currency>';
          $xml .= '<Version>1.28</Version>';
      $xml .= '</Authority> ';
      $xml .= '<BookingId>'.$BookingId.'</BookingId>';
      $xml .= '<CommitLevel>prepare</CommitLevel>';
    $xml .= '</BookingCancel>';
    return $xml;
  }
  public function BookingCancelConfirmXML($BookingId){
    ini_set('max_execution_time', 180); //3 minutes
    $xml = '<BookingCancel xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
    $xml .= '<Authority xmlns="http://www.reservwire.com/namespace/WebServices/Xml">';
    $xml .= '<Org>'.get_option('authority_org').'</Org>';
    $xml .= '<User>'.get_option('authority_user').'</User>';
    $xml .= '<Password>'.get_option('authority_password').'</Password>';
    $xml .= '<Currency>AUD</Currency>';
    $xml .= '<Language>en</Language>';
    $xml .= '<TestDebug>false</TestDebug>';
    $xml .= '<Version>1.28</Version>';
    $xml .= '</Authority>';
    $xml .= '<BookingId>'.$BookingId.'</BookingId>';
    $xml .= '<CommitLevel>confirm</CommitLevel>';
    $xml .= '</BookingCancel>';
    return $xml;
  }
}
