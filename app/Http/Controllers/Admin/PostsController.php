<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Admin;
use App\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PostsController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $posts = Posts::all();
        
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.add');
    }

    public function doCreate(Request $request){
         $postsInfo = Posts::create($request->all());
         $postsInfo = json_encode($postsInfo);
         if (!empty($postsInfo)) {
            echo  $postsInfo;
         }else{
           echo 0;
         }
    	 
    }
    
    public function postEdit($lang,$id)
    {  
        $post =  Posts::where('id', '=' , $id)->get()->first();
        $post->translate($lang);
        return view('admin.posts.edit', compact('post'));
    }

   public function doUpdate(Request $request){
       $lang = \App::getLocale();
       $post = Posts::where('id', Input::get('id'))->first();
       $post->status = $request->status ;
       $post->post_title = $request->post_title;
       $post->post_description = $request->post_description ;
       $post->post_slug  = $request->post_slug ;
       if($post->save()){
         echo $postsInfo = json_encode($post);
       }else{
         echo 0;
       }
      
    exit;
   }

   public function doDelete($lang,$id) {
       $lang = \App::getLocale();
       $post = Posts::where('id', Input::get('id'))->first();
       $res=Posts::where('id',$id)->delete();
       if($res){
        return redirect()->back()->with('message', 'Post deleted successfully'); 
       }
   }

   public function doChange($lang,$id,$st){
       $lang = \App::getLocale();
       $post = Posts::where('id',$id)->first();
       $post->status =$st ;
       if($post->save()){
          return redirect()->back()->with('message', 'Post status changed successfully'); 
       }else{
         return redirect()->back()->with('message', 'Post deleted successfully'); 
       }

   }

}
