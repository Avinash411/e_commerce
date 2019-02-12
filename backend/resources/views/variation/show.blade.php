

{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')

 <div class="card-body">
  <h4 class="card-description">{{ __('All Variant Details') }}</h4>
<table class="table table-striped table-bordered">
	<tr>
    <th>Category</th>
		<th>Variant Name</th>
        
		<th>Action</th>
	</tr>
	@foreach($variant as $key=>$v)
    <tr id="product_part{{$key}}">


    	<td>{{$v[0]->category->category_name}}</td>
      <td>
        <ul class="dot">
        @foreach($v as $value)

       <li> 

<i class="fa fa-angle-right arrow" ></i>
        {{ $value->variant_name}}</li>
        @endforeach
        </ul>
      </td>
    	

    	<td><a href="{{route('get:VariantController:edit',['id'=>$key])}}"><span class="fa fa-pencil-square-o"></span></a>


<i data-id="{{ $key}}" class="delete" ><span class="fa fa-trash-o" ></span></button>
        </td>
    </tr>
     @endforeach

</table></div>




@endsection
@section('js')
<script>
    $(document).on('click','.delete',function(){
  if(confirm("Are you sure you want to delete!")){
  var id=$(this).data('id');
  $.post("/variation/delete",{
    'delete':id,
    '_token':$('input[name="_token"]').val()
  },function(){
    $('#product_part'+id).remove();
  });
}
});
</script>
@endsection
