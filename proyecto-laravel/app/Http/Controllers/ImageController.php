<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;



class ImageController extends Controller{
    
       public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        //llama a el archivo esta carpeta imagen de nombre create
        return view('image.create');    
    }
    
    public function save(Request $request){
        
        //validacion
        $validate = $this->validate($request,[
          'description' =>'required',
          'image_path'  =>'required|image'
         
        ]);
                
        //Recoger Datos
      $image_path = $request->file('image_path');
      $description = $request->input('description');
        
        //asignar valor al objeto
      $user = \Auth::user();
      $image = new Image();
      $image->user_id = $user->id;
      //$image_path = null;
      $image->description = $description;
      
      
      //subir fichero
  if($image_path){
      $image_path_name = time().$image_path->getClientOriginalName();
      Storage::disk('images')->put($image_path_name, File::get($image_path));
        $image->image_path = $image_path_name;
      
        }

        $image->save();
        
        return redirect()->route('home')->with([
            'message'=> 'La foto ha sido subida correctamente!!'
          
        ]);
     }
     public function getImage($filename){
         $file = Storage::disk('images')->get($filename);
         return new Response($file,200);
         
         
     }
       
    
     public function detail($id){
         $image = Image::find($id);
         
         return view('image.detail',[
             'image' => $image
             
         ]);
                 
          }
          
          public function delete($id){
              $user = \Auth::user();
              $image = Image::find($id);
              $comments = Comment::where('image_id', $id)->get();
              $likes = Like::where('image_id',$id)->get();
              
              if($user && $image && $image->user->id == $user->id){
                  
                  //Eliminar Comentarios
                  if($comments && count($comments) >= 1){
                      foreach($comments as $comment){
                          $comment->delete();
                      }
                     } 
              
                  // Eliminar los likes
                  
                    if($likes && count($likes) >= 1){
                      foreach($likes as $like){
                          $like->delete();
                      }
                        }
                  
                  //Eliminar los ficheros de image
                   Storage::disk('images')->delete($image->image_path);     
                    
                  //eliminar los registros de imagen 
                   $image->delete();
                  $message = array('message' => 'la imagen  se ha borrado correctamente.');
              }else{
                  $message = array('message' => 'la imagen no se ha borrado correctamente.');
               
              }
              return redirect()->route('home')->with($message);
              
              
          }
          
          public function edit($id){
            $user = \Auth::user();
            $image = Image::find($id);
            
            if($user && $image && $image->user->id == $user->id){
                return view('image.edit', [
                    'image' =>$image
                ]);
                
            }else{
                return redirect()->route('home');
            }
                 
          }
               
         public function update(Request $request){
             //validacion
        $validate = $this->validate($request,[
          'description' =>'required',
          'image_path'  =>'image'
         
        ]);
             //Recoger los datos
             $image_id = $request->input('image_id');
             $image_path = $request->file('image_path');
             $description = $request->input('description');
             
             //conseguir objeto image
             $image = Image::find($image_id);
             $image->description = $description;
             
             
             //subir fichero
             if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }
        
        //actualizar registro
         $image->update();
         return redirect()->route('image.detail',['id' =>$image_id])
                         ->with(['message' => 'Imagen Actualizada con exito']);
        
        
        
    }
         
    
     } 
     
     
     
     
          
    
          
    
    
    
    
    
    
    
    
    
    
    


