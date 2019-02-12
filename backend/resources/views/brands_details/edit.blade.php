{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                <div class="card-description">{{ __('Edit Brand Details') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('post:BrandController:update')}}">
                        @csrf
                         <input type="hidden" name="id" value="{{ $brand->id }}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Brand Name') }}</label>
                              
                            <div class="col-md-8">
                              
                               <input type="text" name="name" value="{{$brand->brand_name}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Brand Description') }}</label>
                              
                            <div class="col-md-8">
                               
                                <textarea class="form-control" name="details" rows="3" cols="5">{{$brand->brand_description}}</textarea>

                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Refere Category ') }}</label>

                            <div class="col-md-8">

                 <select name="category[]" class="chosen-select form-control" multiple>
                   @foreach($allcategory as $c)

                    <option value="{{$c->id}}" @if(in_array($c->id,$brand_categories))selected @endif >{{$c->category_name}}</option>
          
          
                  @endforeach
           
             </select>
                               
                          </div>
                        </div>
                          <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success"><span class="fa fa-check"></span>
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
