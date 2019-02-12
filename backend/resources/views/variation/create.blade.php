{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card-body">
                <h4 class="card-description">{{ __('Enter All Variants') }}</h4>

                <div class="card-body">
                    <form method="POST" action="{{route('post:VariantController:store')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Variants Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus placeholder="Variants Name ">
                                <small>Enter all variant name or multiple name with comma separated  (,)</small>

                            </div>
                        </div>

                   <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Choose Refer Category') }}</label>

                            <div class="col-md-6">
                                <select name="category" class="chosen-select form-control">
                                    <option></option>
                                    @foreach($category as $c)
                                    <option value="{{$c->id}}">{{$c->category_name}}</option>
                                    @endforeach
                                </select>
                                <small>choose Category where this variant </small>

                            </div>
                        </div>
                          <div class="form-group row mb-0" >
     
      <button type="submit" name="save" class="btn btn-success mdi mdi-check " value="save">
         {{ __('Save') }}</button>
     
     
     <button type="submit" name="save_and_more" class="btn btn-primary mdi mdi-file-document" value="add">
      {{ __('Add more') }}</button>

       <a href="{{route('get:VariantController:show')}}"><button type="button"  name="cancel" class="btn btn-secondary mdi mdi-refresh" value="can">
    {{ __('Cancel') }}</button></a>
     

      </div>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>

@endsection
