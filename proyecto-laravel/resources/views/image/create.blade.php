@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                <div class="card-header">Subir Imagen </div>  

                </br>
                <div class="car-body">
                    <form method="POST" action="{{route('image.save')}}" enctype="multipart/form-data">
                        @csrf  

                        <div class="form-group row">
                            <br>
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                            <div class="col-md-7">
                                <input id="image_path" type="file" name="image_path" class="form-control {{$errors->has('image_path') ? 'is-invalid' : ''}} " />
                                
                                 @if($errors->has('image_path'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{$errors->first('image_path')}}</strong>
                                     @endif
                                 </span>    
                                </div>

                            </div>
                        

                        <div class="form-group row">
                            <br>
                            <label for="description" class="col-md-3 col-form-label text-md-right">Descripcion</label>
                            <div class="col-md-7">
                                <textarea id="description" name="description" class="form-control {{$errors->has('description') ? 'is-invalid' : ''}} " ></textarea>
                                
                                 @if($errors->has('description'))
                                 <span clas="invalid-feedback" role="alert">
                                     <strong>{{$errors->first('description')}}</strong>
                                     @endif
                                 </span>    
                                </div>

                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <input type="submit" class="btn btn-primary" value="Subir Imagen"/>
                            </div>
                        </div>

                                
                           
                        
                        
                    </form>
                          
               
        </div>
    </div>
</div>
@endsection
