{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')
<div class="card-body">
  <h4 class="card-description">{{ __('Restore Product Category Details') }}</h4>
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

   @foreach($parentCategory as $p)

   @if($product->parent_category==$p->id)

   @php $temp=1;@endphp

    {{$p->category_name}}

    @break

   @endif

   @endforeach
   
   @if($temp==0)
   NA
   
   @endif
        </td>
        

    	<td>

<form method="POST" action="{{route('post:ProductsCategoryController:DeletedDataStore')}}">
  @csrf
<input type="hidden" name="id" value="{{$product->id}}">
<input type="Submit" name="" value="Restore" class="btn btn-primary"> 

</form>
            
            
        </td>
    </tr>
     @endforeach

</table>
</div>

@if($errors->all())

                @php

                    print_r($errors->all());
                    
                @endphp


            @endif



@endsection
