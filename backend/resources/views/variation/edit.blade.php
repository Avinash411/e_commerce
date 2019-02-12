{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-description">{{ __('Edit Variants Details') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('post:VariantController:update')}}">
                        @csrf
                         <input type="hidden" name="id" value="{{ $variant[0]['category_id'] }}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right ">{{ __('Variant Name') }}</label>
                              
                            <div class="col-md-8">
                              @php $temp=[]; @endphp
                              @foreach($variant as $v)
                             @php array_push($temp, $v['variant_name']);
                             @endphp
                           @endforeach
                           @php 
                     $variant_name=implode(",",$temp);
                           @endphp

                               <input type="text" name="name" value="{{$variant_name}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
                              
                            <div class="col-md-8">
                              <select name="category" class="chosen-select form-control">
                                  @foreach($category as $c)
                                  @if($c->id==$variant[0]['category_id'])
                                  <option value="{{$c->id}}" selected>{{$c->category_name}}</option>
                                  @else
                                  <option value="{{$c->id}}">{{$c->category_name}}</option>
                                  @endif
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
