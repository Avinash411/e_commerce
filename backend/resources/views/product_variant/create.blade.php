@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Enter All Variants') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('post:ProductVariantController:store')}}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Choose Product Category') }}</label>

                            <div class="col-md-6">
                               <select  name="product_id">
                                <option>choose</option>
                                   @foreach($category as $c)
                                     <option value="{{$c->id}}">{{$c->category_name}}</option>
                                   @endforeach
                               </select>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }}</label>

                            <div class="col-md-6">
                               <select  name="product_id">
                                <option>choose</option>
                                   @foreach($product as $p)
                                     <option value="{{$p->id}}">{{$p->product_name}}</option>
                                   @endforeach
                               </select>

                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Variants Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus placeholder="Variants Name">

                            </div>
                        </div>
                          <div class="form-group row mb-0">
                            <div class="col-md-4 ">
                                <button type="submit" name="save" class="btn btn-success" value="save">
                                    {{ __('Save') }}
                                </button>
                            </div>
                            <div class="col-md-4 ">
                                <button type="submit" name="save_and_more" class="btn btn-primary" value="add">
                                    {{ __('Save and Add more') }}
                                </button>
                            </div>
                        </div>

                    </form>
                     <div class="form-group row ">
                    <div class="col-md-12 ">
                                <a href="{{route('get:ProductVariantController:show')}}"><button style="float: right; margin-top:-35px;" name="cancel" class="btn btn-secondary" value="can">
                                    {{ __('Cancel') }}
                                </button></a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection