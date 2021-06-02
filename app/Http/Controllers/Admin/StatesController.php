<?php
namespace App\Http\Controllers\admin;
use App\States;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class StatesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
         //$states = States::all();
          $states = \DB::table('states')->join('states_translations', 'states.id', '=', 'states_translations.states_id')->get()->all();
         //$states = \DB::table('states')->select('*')->join('states_translations', 'states.id', '=', 'states_translations.states_id')->get()->all();
         //$states = (object)$states;
         // var_dump($states);
        
        return view('admin.states.index', ['states' => $states]);
    }

    public function create()
    {
        return view('admin.states.add');
    }

    public function doadd(Request $request)
    {
        $this->validate($request, [
            'states_name' => 'required|string|max:255',
            'countries_id' => 'required|integer',
        ]);
        $lang =  \App::getLocale();
        $stateInfo = States::create($request->all());
        return redirect()->back()->with('message', 'State added successfully!');
    }

    public function edit($lang, $id)
    {   
        $state =  States::where('id', '=' , $id)->get()->first();
        $state->translate($lang);
        return view('admin.states.edit', compact('state'));
    }

    public function update(Request $request, $lang, $id)
    {
        $this->validate($request, [
            'states_name' => 'required|string|max:255',
            'countries_id' => 'required|integer',
        ]);
        $state = States::where('id', '=' , $id)->get()->first();
        $state->locale = $lang;
        $state->states_name = $request->states_name;
        $state->countries_id = $request->countries_id;
        $state->status = $request->status;
        $state->save();
        return redirect()->back()->with('message', 'State updated successfully!');
    }

    public function doDelete($lang, $id)
    {
        $state = States::where('id', '=' , $id)->get()->first();
        $state->translate($lang);
        States::where('id', $id)->delete();
        return redirect()->back()->with('message', 'State deleted successfully!');
    }
}
