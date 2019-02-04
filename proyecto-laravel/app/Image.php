<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table =  'images';
    
    // relacion one to Many// de uno a muchos
    
    public function comments(){
        
        return $this->hasMany('App\Comment')->OrderBy('id','desc');
        
    }
    
    //relacion One to Many
            
     public function likes(){
        
        return $this->hasMany('App\Like');
        
    }
    
    //relacion de muchos a uno
    
          
     public function user(){
        
        return $this->belongsTo('App\user', 'user_id');
        
    }
    
    
}
