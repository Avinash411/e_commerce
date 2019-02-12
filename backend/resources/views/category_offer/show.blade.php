{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')


<div class="container">
	<div class="card-body">
	<h4 class="card-description">{{ __('All Category Offer Details') }}</h4>
<table class="table table-striped table-bordered">
	<tr>
		<th>Category Name</th>
		<th>Type</th>
		<th>Offer Amount</th>
		<th>Validity From</th>
		<th>Validity To</th>
		<th>Action</th>

	</tr>
	@foreach($offer as $off)
	<tr id="product_part{{$off->id}}">
		<td>{{$off->Category->category_name}}</td>
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
         <a href="{{route('get:CategoryOfferController:edit',['id'=>$off->id])}}"><span class="fa fa-pencil-square-o"></span></a>
		

		<i data-id="{{ $off->id}}" class="delete"><span class="fa fa-trash-o" ></span></i>
			
			
		</td>
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
  $.post("/category_offer/show/delete",{
    'delete':id,
    '_token':$('input[name="_token"]').val()
  },function(){
    $('#product_part'+id).remove();
  });
}
});
</script>
@endsection