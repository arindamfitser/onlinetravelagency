<?php
  namespace App\Http\Controllers\Admin;
  use App\User;
  use App\Admin;
  use App\Pages;

  use Illuminate\Http\Request;
  use App\Http\Controllers\Controller;
  use Illuminate\Support\Facades\Input;

class PagesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $lang =  \App::getLocale(); // 'fr'
        $pages = Pages::all();
        //var_dump($pages);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.add');
    }

    public function doCreate(Request $request){
         $pageInfo = Pages::create($request->all());
         //echo $pageInfo = json_encode($pageInfo);
          $pageInfo->show_in = Input::get('show_in');
          $pageInfo->save();
          $data  = array('id' =>$pageInfo->id ,'lang'=>$pageInfo->locale );
         echo json_encode($data);
         exit;
    	 
    }
    
   public function PageComposer($lang,$id){
        $page =  Pages::where('id', '=' , $id)->get()->first();
        $page->translate($lang);
        //var_dump($page);
         return view('admin.pages.builder', compact('page'));
     }

    public function edit($lang,$id)
    {  
        $page =  Pages::where('id', '=' , $id)->get()->first();
        //$page->translate($lang);
        return view('admin.pages.builder', compact('page'));
    }

   public function doDpdate(Request $request){
       $lang = \App::getLocale();
       $page = Pages::where('id', Input::get('id'))->first();
       $page->template = Input::get('page_template');
       $page->show_in = Input::get('page_show_in');
       $page->status = Input::get('page_status');
       $page->translate($lang)->page_description = Input::get('page_content');
       $page->translate($lang)->page_title = Input::get('page_title');
       $page->save();
       echo 1;
       exit;
   } 

    public function doDelete($lang,$id) {
       $lang = \App::getLocale();
       $post = Pages::where('id', Input::get('id'))->first();
       $res=Pages::where('id',$id)->delete();
       if($res){
        return redirect()->back()->with('message', 'Post deleted successfully'); 
       }
   }

   public function doChange($lang,$id,$st){
       $lang = \App::getLocale();
       $post = Pages::where('id',$id)->first();
       $post->status =$st ;
       if($post->save()){
          return redirect()->back()->with('message', 'Post status changed successfully'); 
       }else{
         return redirect()->back()->with('message', 'Post deleted successfully'); 
       }

   }
   
   public function doPreview(Request $request){
       Session::put('ptitle', Input::get('page_title'));
       Session::put('pcontent', Input::get('page_content'));
       echo 1;
       exit;
   }

}
