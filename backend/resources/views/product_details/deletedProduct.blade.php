{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')
<div class="card-body">
  <h4 class="card-description">{{ __('Restore Product Details') }}</h4>

<table class="table table-striped table-bordered">
	<tr>
		<th>Product Name</th>
		
		<th>Variants</th>
		
		<th>Action</th>
	</tr>
	@foreach($product as $p)
	
	<tr >
		<td style="width: 300px;">{{$p->product_name}}</td>
		
		<td>
			@foreach($variant as $v)

              @if($v->product_id ==$p->id)

              <input type="checkbox" name="variant" class="product_part{{$p->id}}" value="{{$v->id}}">{{$v->combination}} <br>
              <label>Price: </label>
              {{$v->price}}<br>
              <label><strong>Image:</strong></label>
                
                @php 
      $pics=unserialize($v->image);
     
     
     $temp=reset($pics);
       @endphp

@if(empty($pics))
      No Image Uploaded <br>
     @else
        <img src="/Uploads/Variants_image/{{$temp}}" height="100" width="100"><br>
     @endif    
    
<hr>
   
              @endif
     
			@endforeach
		</td>
		
		<td>
			

			<button type="button" data-id="{{ $p->id }}" class="restore btn btn-primary">Restore</button>
	</td>
	</tr>
	
	@endforeach
</table>

</div>
@endsection
@section('js')

<script>
	$(document).on('click','.restore',function(){
  if(confirm("Are you sure you want to Restore it!")){
  var id=$(this).data('id');
var arr=[];
$("input:checkbox[name=variant]:checked").each(function(){
    arr.push($(this).val());
});
console.log(arr);
  if(arr.length){
  $.post("/product/restore",{
    'id':id,
    'variant_id':arr,
    '_token':$('input[name="_token"]').val()
  },function(){
    //$('#product_part'+id).remove();
    location.reload();
  });
}
else{
	alert("Please select variant");
}
}
});

</script>
@endsection