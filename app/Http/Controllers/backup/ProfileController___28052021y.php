namespace App\Http\Controllers;
use App\Hotels;
use App\Rooms;
use App\RoomCategory;
use App\RoomDetail;
use App\RoomGallery;
use App\Booking;
use Illuminate\Http\Request;
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth('web')->user();
        if($user->role=='1'){
            $hotels = Hotels::where('user_id', '=', $user->id)->get()->All();
            if (!empty($hotels)) {
                $room = new \StdClass();
                $room->hotel_id = Hotels::where('user_id', '=', $user->id)->get()->first()->id;
                $room->rooms = Rooms::where('hotel_id', '=',Hotels::where('user_id', '=', $user->id)->get()->first()->id)->get()->all();
            }else{
                $room = new \StdClass();
            }
            return view('frontend.hotelier.dashboard', compact('room', 'hotels'));
        }else{
            return view('frontend.customer.dashboard');
        }  
    }
    
    public function profile()
    {
        $user = auth('web')->user();
       if($user->role=='1'){
          return view('frontend.hotelier.profile');
        }else{
          return view('frontend.customer.profile');
        }
        
    }
}
