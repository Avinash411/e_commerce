{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-description">{{ __('Edit Variant Value') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('post:VariantValueController:update')}}">
                        @csrf
                       
                         <input type="hidden" name="id" value="{{ $value[0]->variant_id }}">

             <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Refer Category') }}</label>
                              
                            <div class="col-md-8">
                               
                               <input type="text" value="{{$category->category_name}}" readonly class="form-control">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Select Variant ') }}</label>
                              
                            <div class="col-md-8">
                              <select name="variant" class="chosen-select form-control">
                                
                               @foreach($allvariant as $v)
                                <option value="{{$v->id}}" @if($v->id==$value[0]->variant_id)selected @endif >{{$v->variant_name}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Value Name') }}</label>
                              
                            <div class="col-md-8">
                               
                               <input type="text" name="name" value="{{$allname}}"class="form-control">
                               <small>Enter all variant value or multiple value with comma separated(,)</small>
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
