<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\like;


class likeController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
 
      }  
      
      
       public function index(){
           $user = \Auth::user();
             $likes = like::where('user_id',$user->id)->OrderBy('id', 'desc')
                                  ->paginate(5);
             
             return view('like.index',[
                 'likes' => $likes
             ]);
             
             
         }
           
      
      public function like($image_id){
          //recoger datos del usuario y la imagen
          $user = \Auth::user();
          
          //condicion para ver si ya existe el like y no duplicarlo
          $isset_like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->count(); 
          if($isset_like ==0){
              
          
          $like = new Like();
          $like->user_id = $user->id;
          $like->image_id = (int)$image_id;
          
          //guardar en la base de datos
          
          $like->save();
          
          return response()->json([
              'like' => $like
          ]);
          

          }else{
              return response()->json([
              'message' => ' el like ya existe '
          ]);
          
          }
         
          } 
          
       
       public function dislike($image_id){
           
            //recoger datos del usuario y la imagen
          $user = \Auth::user();
          
          //condicion para ver si ya existe el like y no duplicarlo
          $like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->first(); 
          if($like){
               //eliminar el like
         
          $like->delete();
          
          return response()->json([
              'like' => $like,
           'message' =>'Has dado dislike correctamente'
          ]);
          

          }else{
              return response()->json([
              'message' => 'has dado dislike correctamente '
          ]);
          
          }
         
         }  
    
    
}




