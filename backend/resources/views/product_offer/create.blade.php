{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                <h4 class="card-description">{{ __('Enter Product Offer Details') }}</h4>

                <div class="card-body">
                    <form method="POST" action="{{route('post:ProductOfferController:store')}}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }}</label>

                            <div class="col-md-6">
                                <select  name="choose_product_name" 
                                  placeholder="Select Your Product"  class="form-control chosen-select">
                                  <option ></option>
                                	@foreach($product as $p)
                                    <option value="{{$p->id}}">{{$p->product_name}}</option>
                                	@endforeach
                                </select>

                            </div>
                        </div>
                       <div class="form-group row">
                            <label for="offer" class="col-md-4 col-form-label text-md-right">{{ __('Choose Offer Type') }}</label>

                            <div class="col-md-6">
                                
                                <input type="radio" name="type" class="form-group" value="flats">Flats <br>
                                <input type="radio" name="type"  class="form-group" value="percentage">Percentage
                               
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Offer Amount') }}</label>

                            <div class="col-md-6 opt">
                                
                                <input type="text" class="form-group" name="amount" value="{{old('amount')}}">
                  
                   <select name="amount_type">
                   	<option value="0"></option>
                   	<option value="flats">&#8377;</option>
                   	<option value="percentage">%</option>
                   </select>                                
                             
                          </div>
                        </div>
                         <div class="form-group row">
                            <label for="From" class="col-md-4 col-form-label text-md-right">{{ __('Starting Offer') }}</label>

                            <div class="col-md-6">
                                Date
                                <input id="datepicker" name="from" width="276" /> Time
                              <input id="timepicker"  name="from_t" width="276" />

                               
                               
                          </div>
                        </div>
                         
                       <div class="form-group row">
                            <label for="To" class="col-md-4 col-form-label text-md-right">{{ __('Ending Offer') }}</label>


                            <div class="col-md-6">
                            	Date
                             <input id="datepicker1" name="to" width="276" />Time
                                <input id="timepicker1" name="to_t" width="276" />
                          </div>
                        </div>
                         
                         <div class="form-group row mb-0" >
     
      <button type="submit" name="save" class="btn btn-success mdi mdi-check " value="save">
         {{ __('Save') }}</button>
     
     
     <button type="submit" name="save_and_more" class="btn btn-primary mdi mdi-file-document" value="add">
      {{ __('Add more') }}</button>

       <a href="{{route('get:ProductOfferController:show')}}"><button type="button"  name="cancel" class="btn btn-secondary mdi mdi-refresh" value="can">
    {{ __('Cancel') }}</button></a>
     

      </div>

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
		$("input[name=type]").change(function(){
			
         var temp= $('input[name=type]:checked').val();
         
          	$(".opt select").val(temp);
          
        
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
       // format:'h:m A'
       format: 'hh:MM TT'
      });
$('#timepicker1').timepicker({
       /// format:'h:m A'
       format: 'hh:MM TT'
});
//  $(document).ready(function() {
// // $('#select').selectstyle();

// $('.chosen-select').chosen();
//  });

    </script>

@endsection