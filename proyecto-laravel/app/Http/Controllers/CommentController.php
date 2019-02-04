<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
      public function __construct(){
    
        $this->middleware('auth');
    }
    
    public function save(Request $request){
        
           //validacion
        $validate = $this->validate($request, [
            'image_id' =>'integer|required',
            'content' =>'string|required',
          ]);
         
        //recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');
      
       //asignar valor al objeto
         $comment = new Comment();
         $comment->user_id = $user->id;
         $comment->image_id = $image_id;
         $comment->content = $content;
        
        //guardo en la base de datos
         
        $comment->Save();
        
      //  redirecciono
      return redirect()->route('image.detail',['id' => $image_id])
                 ->with([
                     'message' => 'Has Publicado tu Comentario Correctamente'
                 ]);
        
        
    }
    
    public function delete($id){
        //conseguir datos del usuario identificado
          $user = \Auth::user();
          
          // conseguir objeto del comentario
          
           $comment = Comment::find($id);
           
           //comprobar si soy dueño del comentario o de publicacion
           
           if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
               $comment->delete();
               
                  return redirect()->route('image.detail',['id' => $comment->image->id])
                 ->with([
                     'message' => 'Comentario eliminado de forma correcta'
                 ]);
           }else{
                return redirect()->route('image.detail',['id' => $comment->image->id])
                 ->with([
                     'message' => 'comentario no se ha eliminado'
                 ]);
           }
           
           
           
        
        
    }
    
    
    
    
    
    
    
}
