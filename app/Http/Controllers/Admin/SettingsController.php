<?php

namespace App\Http\Controllers\Admin;
use App\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin'); 
    }

    public function general_settings(){
        $options = Options::all();
        $currency = DB::table('currency')->get()->all();
    	return view('admin.settings.general', compact('options','currency'));

    }

    public function save_general_settings(Request $request, $lang){
        $request_data = $request->all();
        
        foreach ($request_data as $key => $value) {
            $options = Options::where('option_name', '=', $key)->get()->first();
            if(!empty($options)){
                if($key == 'site_logo'){
                    $file = $request->file($key);
                    if($file){
                        $image = $file->getClientOriginalName();
                        $path = $request->$key->store('public/uploads');
                        $options->options_value = $path;
                    }
                }else{
                        $options->options_value = $value;
                }
                $options->save();
            }else{
               /*  $opt = Options::create();
                 $opt->option_name = $key;
                 $opt->options_value = $value;
                 $opt->save();*/
            }
        }
        return redirect()->back()->with('message', 'Settings updated successfully!');
    }
    
}
