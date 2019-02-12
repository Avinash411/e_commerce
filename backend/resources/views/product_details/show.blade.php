{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')

<div class="card-body">
	<h4 class="card-description">{{ __('All Product Details') }}</h4>
<table class="table table-striped table-bordered">
	<tr>
		<th>Product Name</th>
		<th>Category</th>
		<th>Brand</th>
		
		<th>Action</th>
	</tr>
	@foreach($product as $p)
	
	<tr id="product_part{{$p->id}}">
		<td style="width: 300px;">{{$p->product_name}}</td>
		
		<td>{{$p->category->category_name}}</td>
		<td>{{$p->brand['brand_name']}}</td>
	
		
		<td><a href="{{route('get:ProductController:edit',[$p->id])}}"><span class="fa fa-pencil-square-o"></span></a>
			<i data-id="{{ $p->id }}" class="delete"><span class="fa fa-trash-o" ></span></button>
	</td>
	</tr>
	
	@endforeach
</table>

</div>
@endsection
@section('js')
<script src="{{asset('js\show_script.js')}}"></script>
@endsection

