{{--@extends('layouts.app')--}}
@extends('backend.layout')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-description">{{ __('Edit Prodect Category Details') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('post:ProductsCategoryController:update')}}">
                        @csrf
                         <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $product->category_name }}" required autofocus placeholder="Category Name">

                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Parent Category') }}</label>

                            <div class="col-md-6">
                                <select name="category" class="chosen-select form-control">
            @foreach($allcategory as $c)
          
            <option value="{{$c->id}}" @if($product->parent_category==$c->id)selected @endif >{{$c->category_name}}</option>
          
          
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
