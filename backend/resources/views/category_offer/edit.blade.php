{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-description">{{ __('Edit Category Offer Details') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('post:CategoryOfferController:update')}}">
                        @csrf
                         <input type="hidden" name="id" value="{{ $offer->id }}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>

                            <div class="col-md-6">
                                <select name="choose_category" class="chosen-select form-control">
                                	<option value="{{$offer->category_id}}">{{$offer->Category->category_name}}</option>
                                	@foreach($allcategory as $c)
                                	<option value="{{$c->id}}">{{$c->category_name}}</option>
                                	@endforeach
                                </select>
                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Choose Offer Type') }}</label>

                            <div class="col-md-6">
                            	@if($offer->type=="flats")
                               <input type="radio" name="type" class="form-group" value="flats" checked>Flats <br>
                               
                               @else 
                               <input type="radio" name="type" class="form-group" value="flats">Flats <br>
                               @endif
                                @if($offer->type=="percentage")
                                <input type="radio" name="type"  class="form-group" value="percentage" checked>Percentage <br>
                                
                                @else
                                <input type="radio" name="type"  class="form-group" value="percentage" >Percentage <br>
                               @endif
                               

                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Offer Amount') }}</label>

                            <div class="col-md-6 opt">
                                
                                <input type="text" class="form-group" name="amount" value="{{$offer->offer_amount}}">
		                     <select name="amount_type">
		                   	<option value="0"></option>
		                   	<option value="flats">&#8377;</option>
		                   	<option value="percentage">%</option>
		                   </select>    
                
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Starting Offer') }}</label>

                            <div class="col-md-6">
                             
                               Date
                              <input id="datepicker" name="from" value="{{ \Carbon\Carbon::parse($offer->validity_From)->format('d/m/Y')}}" width="276" /> Time
                              <input id="timepicker" name="from_t" value="{{ \Carbon\Carbon::parse($offer->validity_From)->format('h:i A')}}" width="276" />
                               
                              
                          </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Ending Offer') }}</label>

                            <div class="col-md-6">
                              
                                Date
                             <input id="datepicker1" name="to" value="{{ \Carbon\Carbon::parse($offer->validity_To)->format('d/m/Y')}}" width="276" />Time
                                <input id="timepicker1" name="to_t" value="{{ \Carbon\Carbon::parse($offer->validity_To)->format('h:i A')}}" width="276" />
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
	$(document).ready(function(){
		
		if($('input[name=type]:checked')){	
         var temp= $('input[name=type]:checked').val();
         
          	$(".opt select").val(temp);
          }
        
		
		 $("input[name=type]").change(function(){
		if($('input[name=type]:checked')){	
         var temp= $('input[name=type]:checked').val();
         
          	$(".opt select").val(temp);
          }
        
		});
	});

        $('#datepicker').datepicker({
          format: 'dd/mm/yyyy',
            uiLibrary: 'bootstrap4'
        });
         $('#datepicker1').datepicker({
          format: 'dd/mm/yyyy',
            uiLibrary: 'bootstrap4'
        });
      $('#timepicker').timepicker({
        format: 'hh:MM TT'
      });
$('#timepicker1').timepicker({
  format: 'hh:MM TT'
});
    </script>

@endsection