

@extends('backend.layout')

@section('content')

<div class="card-body">

  <h4 class="card-description">{{ __('All Brand Details') }}</h4>
<table class="table table-striped table-bordered">
	<tr>
		<th>Brand Name</th>
		<th>Brand Description</th>
        <th>Refere Category</th>
		<th>Action</th>
	</tr>
  @foreach($brand as $key => $b)
	
    <tr id="product_part{{$b[0]->id}}">
    	<td>{{ $key}}</td>
    	<td>{{ substr($b[0]->brand_description,0,150)}}</td>
        <td>
          <ul class="dot">
          @foreach($b as $categories)
          <li>
        <i class="fa fa-angle-right arrow" ></i>
          {{ $categories->category->category_name }}
          </li>
          @endforeach
          </ul>
        </td>
        
    	<td>
          <div class="d-print-inline">
            <a href="{{route('get:BrandController:edit',['id'=>$b[0]->id])}}"><span class="fa fa-pencil-square-o"></span></a>
     
        
<i data-id="{{ $b[0]->id}}" class="delete" ><span class="fa fa-trash-o" ></span></i></div>
        </td>
    </tr>
     @endforeach

</table>
</div>

@section('js')
<script>
    $(document).on('click','.delete',function(){
  if(confirm("Are you sure you want to delete!")){

    //alert($(this).data('id'));
  var id=$(this).data('id');
 // console.log(id);
  $.post("/brand/delete",{
    'delete':id,
    '_token':$('input[name="_token"]').val()
  },function(){
    $('#product_part'+id).remove();
  });
}
});
</script>
@endsection




@endsection
