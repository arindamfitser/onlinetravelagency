<?php
namespace App\Http\Controllers;
use App\Filter;
use App\Countries;
use App\Regions;
use App\States;
use App\Hotels;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\RoomAvailability;
use App\Cart;
use App\User;
use App\StatesTranslation;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Session;
class LoadXmlController extends Controller
{
    public function __construct(){
    }
    private function pr($data){
        echo "<pre>";
        print_r($data);
        die;
    }
    public function hotel(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '90000000000000');
        $path   = public_path('hotelDetailsXML');
        $files  = scandir($path);
        $count  = 0;
        foreach($files as $val):
            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if ($ext == 'xml') :
                $xml        = simplexml_load_file($path.'/'.$val);
                $xml        = (array) $xml;
                if (array_key_exists("HotelElement", $xml)):
                    $xml        = $xml['HotelElement'];
                    $xml        = (array) $xml;
                endif;
                $hotel_id   = $xml['Id'];
                
                // if($hotel_id == '178834'):
                //     $this->pr($xml);
                // endif;
                
                
                
                $count      = 0;
                $check      = DB::table('hotel_master_xml')->select('id')->where('hotel_master_xml.id', $hotel_id)->get()->first();
                if(empty($check)):
                    $region     = (isset($xml['Region']) && !empty($xml['Region'])) ? (array) $xml['Region'] : array();
                    $genInfo    = (isset($xml['GeneralInfo']) && !empty($xml['GeneralInfo'])) ? (array) $xml['GeneralInfo'] : array();
                    $rating     = (isset($xml['Rating']) && !empty($xml['Rating'])) ? (array) $xml['Rating'] : array();
                    DB::table('hotel_master_xml')->insert(
                        array(
                            'id'                  => $hotel_id, 
                            'name'                => (isset($xml['Name'])) ? ((!empty((array) $xml['Name'])) ? $xml['Name'] : '') : '',
                            'region_id'           => (isset($region['Id'])) ? ((!empty((array) $region['Id'])) ? $region['Id'] : '') : '',
                            'region_name'         => (isset($region['Name'])) ? ((!empty((array) $region['Name'])) ? $region['Name'] : '') : '',
                            'city_id'             => (isset($region['CityId'])) ? ((!empty((array) $region['CityId'])) ? $region['CityId'] : '') : '',
                            'type'                => (isset($xml['Type'])) ? ((!empty((array) $xml['Type'])) ? $xml['Type'] : '') : '',
                            'stars'               => (isset($xml['Stars'])) ? ((!empty((array) $xml['Stars'])) ? $xml['Stars'] : '') : '',
                            'latitude'            => (isset($genInfo['Latitude'])) ? ((!empty((array) $genInfo['Latitude'])) ? $genInfo['Latitude'] : '') : '',
                            'longitude'           => (isset($genInfo['Longitude'])) ?((!empty((array) $genInfo['Longitude'])) ? $genInfo['Longitude'] : '') : '',
                            'rating_system'       => (isset($rating['System'])) ? ((!empty((array) $rating['System'])) ? $rating['System'] : '') : '',
                            'rating_score'        => (isset($rating['Score'])) ? ((!empty((array) $rating['Score'])) ? $rating['Score'] : '') : '',
                            'rating_description'  => (isset($rating['Description'])) ? ((!empty((array) $rating['Description'])) ? $rating['Description'] : '') : '',
                            'rank'                => (isset($xml['Rank'])) ? ((!empty((array) $xml['Rank'])) ? $xml['Rank'] : '') : ''
                        )
                    );
                    $count++;
                endif;
            endif;
        endforeach;
        echo $count . ' hotels added !!!';
    }
    public function address(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '90000000000000');
        $path   = public_path('hotelDetailsXML');
        $files  = scandir($path);
        $count = 0;
        foreach($files as $val):
            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if ($ext == 'xml') :
                $xml        = simplexml_load_file($path.'/'.$val);
                $xml        = (array) $xml;
                if (array_key_exists("HotelElement", $xml)):
                    $xml        = $xml['HotelElement'];
                    $xml        = (array) $xml;
                endif;
                $hotel_id   = $xml['Id'];
                $check  = DB::table('hotel_address_xml')->where('hotel_address_xml.hotel_id', $hotel_id)->get()->first();
                if(empty($check)):
                    //$this->pr($xml);
                    $address    = (isset($xml['Address']) && !empty($xml['Address'])) ? (array) $xml['Address'] : array();
                    DB::table('hotel_address_xml')->insert(
                        array(
                            'hotel_id'    => $hotel_id, 
                            'Address1'    => (isset($address['Address1'])) ? ((!empty((array) $address['Address1'])) ? $address['Address1'] : '') : '',
                            'Address2'    => (isset($address['Address2'])) ?((!empty((array) $address['Address2'])) ? $address['Address2'] : '') : '',
                            'Address3'    => (isset($address['Address3'])) ? ((!empty((array) $address['Address3'])) ? $address['Address3'] : '') : '',
                            'City'        => (isset($address['City'])) ? ((!empty((array) $address['City'])) ? $address['City'] : '') : '',
                            'State'       => (isset($address['State'])) ? ((!empty((array) $address['State'])) ? $address['State'] : '') : '',
                            'Zip'         => (isset($address['Zip'])) ? ((!empty((array) $address['Zip'])) ? $address['Zip'] : '') : '',
                            'Country'     => (isset($address['Country'])) ? ((!empty((array) $address['Country'])) ? $address['Country'] : '') : '',
                            'Tel'         => (isset($address['Tel'])) ? ((!empty((array) $address['Tel'])) ? $address['Tel'] : '') : '',
                            'Fax'         => (isset($address['Fax'])) ? ((!empty((array) $address['Fax'])) ? $address['Fax'] : '') : '',
                            'Email'       => (isset($address['Email'])) ? ((!empty((array) $address['Email'])) ? $address['Email'] : '') : ''
                        )
                    );
                    $count++;
                endif;
            endif;
        endforeach;
        echo $count . ' hotels added !!!';
    }
    public function aminity(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '90000000000000');
        $path   = public_path('hotelDetailsXML');
        $files  = scandir($path);
        $count = 0;
        foreach($files as $val):
            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if ($ext == 'xml') :
                $xml        = simplexml_load_file($path.'/'.$val);
                $xml        = (array) $xml;
                if (array_key_exists("HotelElement", $xml)):
                    $xml        = $xml['HotelElement'];
                    $xml        = (array) $xml;
                endif;
                $hotel_id   = $xml['Id'];
                $check      = DB::table('hotel_amenity_xml')->where('hotel_amenity_xml.hotel_id', $hotel_id)->get()->first();
                if(empty($check)):
                    //$this->pr($xml);
                    if(isset($xml['Amenity']) && !empty($xml['Amenity'])):
                        foreach($xml['Amenity'] as $k => $amenity):
                            $amenity = (array) $amenity;
                            DB::table('hotel_amenity_xml')->insert(
                                array(
                                    'hotel_id'  => $hotel_id,
                                    'Code'      => (isset($amenity['Code'])) ? ((!empty((array) $amenity['Code'])) ? $amenity['Code'] : '') : '',
                                    'Text'      => (isset($amenity['Text'])) ? ((!empty((array) $amenity['Text'])) ? $amenity['Text'] : '') : ''
                                )
                            );
                        endforeach;
                        $count++;
                    endif;
                endif;
            endif;
        endforeach;
        echo $count . ' hotels added !!!';
    }
    public function description(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '90000000000000');
        $path   = public_path('hotelDetailsXML');
        $files  = scandir($path);
        $count = 0;
        foreach($files as $val):
            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if ($ext == 'xml') :
                $xml        = simplexml_load_file($path.'/'.$val);
                $xml        = (array) $xml;
                if (array_key_exists("HotelElement", $xml)):
                    $xml        = $xml['HotelElement'];
                    $xml        = (array) $xml;
                endif;
                $hotel_id   = $xml['Id'];
                $check  = DB::table('hotel_description_xml')->where('hotel_description_xml.hotel_id', $hotel_id)->get()->first();
                if(empty($check)):
                    if(isset($xml['Description']) && !empty($xml['Description'])):
                        foreach($xml['Description'] as $k => $desc):
                            $desc = (array) $desc;
                            DB::table('hotel_description_xml')->insert(
                                array(
                                    'hotel_id'   => $hotel_id,
                                    'Language'   => (isset($desc['Language'])) ? ((!empty((array) $desc['Language'])) ? $desc['Language'] : '') : '',
                                    'Type'       => (isset($desc['Type'])) ? ((!empty((array) $desc['Type'])) ? $desc['Type'] : '') : '',
                                    'Text'       => (isset($desc['Text'])) ? ((!empty((array) $desc['Text'])) ? $desc['Text'] : '') : ''
                                )
                            );
                        endforeach;
                        $count++;
                    endif;
                endif;
            endif;
        endforeach;
        echo $count . ' hotels added !!!';
    }
    public function image(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '90000000000000');
        $path   = public_path('hotelDetailsXML');
        $files  = scandir($path);
        $count = 0;
        foreach($files as $val):
            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if ($ext == 'xml') :
                $xml        = simplexml_load_file($path.'/'.$val);
                $xml        = (array) $xml;
                if (array_key_exists("HotelElement", $xml)):
                    $xml        = $xml['HotelElement'];
                    $xml        = (array) $xml;
                endif;
                $hotel_id   = $xml['Id'];
                $images     = DB::table('hotel_images_xml')->select('*')->where('hotel_images_xml.hotel_id', $hotel_id)->get();
                if(empty($images)):
                    $photoHotel = (isset($xml['Photo']) && !empty($xml['Photo'])) ? (array) $xml['Photo'] : array();
                    if(!empty($photoHotel)):
                        foreach($xml['Photo'] as $k => $pic):
                            $pic = (array) $pic;
                            DB::table('hotel_images_xml')->insert(
                                array(
                                    'hotel_id'          => $hotel_id,
                                    'Url'               => (isset($pic['Url'])) ? $pic['Url'] : '',
                                    'Width'             => (isset($pic['Width'])) ? $pic['Width'] : '',
                                    'Height'            => (isset($pic['Height'])) ? $pic['Height'] : '',
                                    'Bytes'             => (isset($pic['Bytes'])) ? $pic['Bytes'] : '',
                                    'Caption'           => '',
                                    'ThumbnailUrl'      => (isset($pic['ThumbnailUrl'])) ? $pic['ThumbnailUrl'] : '',
                                    'ThumbnailWidth'    => (isset($pic['ThumbnailWidth'])) ? $pic['ThumbnailWidth'] : '',
                                    'ThumbnailHeight'   => (isset($pic['ThumbnailHeight'])) ? $pic['ThumbnailHeight'] : '',
                                    'ThumbnailBytes'    => (isset($pic['ThumbnailBytes'])) ? $pic['ThumbnailBytes'] : '',
                                    'PhotoType'         => (isset($pic['PhotoType'])) ?  $pic['PhotoType'] : ''
                                )
                            );
                        endforeach;
                        $count++;
                    endif;
                endif;
            endif;
        endforeach;
        echo $count . ' hotels added !!!';
    }
    public function testEmail(){
        Mail::raw('Text to e-mail', function ($message) {
            $message->from('no-reply@luxuryfishing.com', 'Luxury Fishing');
            $message->to('anurag.sen@met-technologies.com', 'Anurag Sen')->subject('Invitaion To Register | Luxury Fishing');
        });
        die;
        // $data = array('name'=>"Sylvester Stallone");
   
        // Mail::send(['text'=>'mail'], $data, function($message) {
        //     $message->to('anurag.sen@met-technologies.com', 'Anurag Sen')->subject
        //         ('Laravel Basic Testing Mail');
        //     $message->from('no-reply@luxuryfishing.com','Luxury Fishing');
        // });
        // die;
        $e_data = array(
            'hotel_name'            => 'ASD',
            'address'               => 'ASD',
            'country'               => 'ASD', 
            'state'                 => 'ASD',
            'city'                  => 'ASD', 
            'representative_name'   => 'ASD',
            'contact_email'         => 'anurag.sen@met-technologies.com', 
            'contact_phone'         => 'ASD'
        );
        Mail::send('emails.direct-contract-invitation', ['e_data' => $e_data], function ($m) use ($e_data) {
            $m->from('no-reply@luxuryfishing.com', 'Luxury Fishing');
            $m->to($e_data['contact_email'], $e_data['representative_name'])->subject('Invitaion To Register | Luxury Fishing');
        });
    }
}
