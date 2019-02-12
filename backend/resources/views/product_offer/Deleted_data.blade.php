{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')
<div class="container">

<div class="card-body">
  <h4 class="card-description">{{ __('Restore Product Offer Details') }}</h4>
<table class="table table-striped table-bordered">
	<tr>
		<th>Product Name</th>
		<th>Type</th>
		<th>Offer Amount</th>
		<th>Validity From</th>
		<th>Validity To</th>
		<th>Action</th>

	</tr>
	@foreach($offer as $off)
	<tr id="product_part{{$off->id}}">
		<td>{{$off->product->product_name}}</td>
		<td>{{ $off->type }}</td>
		<td>{{ $off->offer_amount }}</td>
		<td>
{{ \Carbon\Carbon::parse($off->validity_From)->format('d/m/Y')}}<br>
{{ \Carbon\Carbon::parse($off->validity_From)->format('h:m A')}}
			</td>
		<td>
{{ \Carbon\Carbon::parse($off->validity_To)->format('d/m/Y')}}<br>
{{ \Carbon\Carbon::parse($off->validity_To)->format('h:m A')}}
		</td>
		<td> 
<div class="row">

<form method="POST" action="{{route ('post:ProductOfferController:DeletedDataStore')}}">
	
	@csrf
          <input type="hidden" name="id" value="{{$off->id}}">
          <input type="Submit" name="" value="Restore" class="btn btn-primary" >
</form>
         


        
		
		<i data-id="{{ $off->id}}" class="delete" style="float:left;margin-top: -30px;padding-right: 30px"><span class="fa fa-trash-o" ></span></i>

			
		</td></div>
	</tr>
	@endforeach
</table>
</div>
</div>
@endsection
@section('js')
<script>
    $(document).on('click','.delete',function(){
  if(confirm("Are you sure you want to delete!")){
  var id=$(this).data('id');
  $.post("/product_offer/forcefullydelete",{
    'id':id,
    '_token':$('input[name="_token"]').val()
  },function(){
    $('#product_part'+id).remove();
  });
}
});
</script>
@endsection