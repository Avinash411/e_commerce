

{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')
<div class="card-body">
  <h4 class="card-description">{{ __('Restore Variant Details') }}</h4>
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
      <td>
        <form method="POST" action="{{route('post:VariantController:RestoreData')}}">
          @csrf
          <input type="hidden" name="id" value="{{$key}}">
          <input type="Submit" name="" value="Restore" class="btn btn-primary">
         
        </form>
        </td>
    </tr>
     @endforeach

</table>
</div>




@endsection
