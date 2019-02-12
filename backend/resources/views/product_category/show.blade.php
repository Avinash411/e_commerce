



{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')

<div class="card-body">
  <h4 class="card-description">{{ __('All Product Category Details') }}</h4>
<table class="table table-striped table-bordered">
	<tr>
		<th>Category Name</th>
		<th>Parent Category</th>
		<th>Action</th>
	</tr>
	<!-- this loop for fetching data from database like productCategory object of the call product category that i send by compact then display by loop-->
	@foreach($productCategory as $product)
    <tr id="product_part{{$product->id}}">
    	<td>{{ $product->category_name}}</td>


    	<td>
            @php $temp=0;@endphp
   @foreach($productCategory as $p)
   @if($product->parent_category==$p->id)
   @php $temp=1;@endphp
    {{ $p->category_name}}
    @break
   @endif
   @endforeach
   @if($temp==0)
   NA
   
   @endif
        </td>
        

    	<td><a href="{{route('get:ProductsCategoryController:edit',['id'=>$product->id])}}"><span class="fa fa-pencil-square-o"></span></a>

            
            <i data-id="{{ $product->id}}" class="delete"><span class="fa fa-trash-o" ></span></i>
        </td>
    </tr>
     @endforeach

</table>
</div>
@section('js')
<script>
    $(document).on('click','.delete',function(){
  if(confirm("Are you sure you want to delete!")){
  var id=$(this).data('id');
  $.post("/category/delete",{
    'id':id,
    '_token':$('input[name="_token"]').val()
  },function(){
    $('#product_part'+id).remove();
  });
}
});
</script>
@endsection
@if($errors->all())

                @php

                    print_r($errors->all());
                    
                @endphp


            @endif



@endsection
