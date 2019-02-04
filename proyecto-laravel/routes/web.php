<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//use App\image;
//use App\User;

Route::get('/', function () {
   
    /*$images = image::all();                      // saco todas las imagenes de la base de datos
    foreach ($images as $image){                 // recorre la imagen  
        echo $image->image_path."</br>"; 
        echo $image->description."</br>"; 
        echo $image->user->name.'  '.$image->user->surname;
        echo '<h4>comentarios</h4>';
        foreach ($image->comments as $comment){
            echo $comment->content.'<br/>';
            echo 'LIKES: '.count($image->likes);
        } }
    */
    
    return view('home');
});

//RUTAS GENERALES
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


//RUTAS PARA USUARIOS
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
Route::get('/perfil/{id}', 'UserController@profile')->name('profile');
Route::get('/personas/{search?}', 'UserController@index')->name('user.index');


//RUTA DE imagen
Route::get('/crear-imagen', 'ImageController@create')->name('image.create');
Route::Post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');
Route::get('/imagen/editar/{id}', 'ImageController@edit')->name('image.edit');
Route::Post('/image/update', 'ImageController@update')->name('image.update');


//COMENTARIOS
Route::Post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

//LIKES
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'likeController@dislike')->name('like.delete');
Route::get('/likes', 'LikeController@index')->name('likes');

