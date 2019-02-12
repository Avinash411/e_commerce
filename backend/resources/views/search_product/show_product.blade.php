@extends('layouts.app')
@section('content')
<div class="row">
<div class="card col-md-4">
	<div class="row">
	<div class="col-md-4">

	   
	   @php
	   $img=unserialize($product->image);

	   @endphp
	     @if(empty($img))
      no Image Uploaded
     @endif    
      @foreach($img as $key=>$pic)
     
      
    <img src="/Uploads/Product_images/{{ $pic }}"  height="100" width="100" class="img">
    

    @endforeach
    @foreach($product->getProductVariant as $v)
    @php
	   $img=unserialize($v->image);

	   @endphp
	     @if(empty($img))
      no Image Uploaded
     @endif    
      @foreach($img as $key=>$pic)
     
      
    <img src="/Uploads/Variants_image/{{ $pic }}"  height="100" width="100" class="img">
    

    @endforeach
@endforeach
	   
	</div>
	<div class="card col-md-8" id="image">
	
	</div></div>
</div>
<div class="card col-md-8">
	@if(isset($path))

<ul style=" list-style:none;display: flex;">
	
@foreach($path as $key => $value)

<a href="/api/path_data/{{$key}}"><li>{{$value}}</li></a> ->

@endforeach
</ul>
@endif
	
<ul style="list-style: none;">
	
	<li><b>{{$product->product_name}}</b></li>
	<b>Description:</b>
	<li>{{$product->product_description}}</li>
	<li style="color: blue">{{$product->brand->brand_name}}</li>
	<li>{{$product->brand->brand_description}}</li>

	@foreach($product->getProductVariant as $v)
	@if($v->combination)
     <b>type</b>
     <li>{{$v->combination}}</li>
     <div style="margin-top: -50px;margin-left: 80px">
	@endif
	
	
    <li >
    	<b>Price</b>
{{--    	@php $t=1; @endphp
@foreach($offer as $key=>$off)
    @if($key==$v->product_id)
      {{$v->price-$off}}<br>
      <strike>
      {{$v->price}}  </strike>	
  @php $t=0; @endphp
  @endif




  @endforeach
		@if($t)
		{{$v->price}}
		@endif
	--}}
{{--{{$percent['0']['percent']}}	--}}<br>

    </li><br></div>
	@endforeach
</ul>

</div></div>
@endsection
@section('js')

@endsection