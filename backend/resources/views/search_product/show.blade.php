@extends('layouts.app')
@section('content')
<div class="row">
<div class="card col-md-3">
	<label><strong>Show results for</strong></label><hr>
	<label>CATEGORIES</label>
@if(isset($path))
	
<ul style=" list-style:none;">
	
@foreach($path as $key => $value)

<a href="/api/path_data/{{$key}}"><li>< {{$value}}</li></a> 

@endforeach
</ul>
@endif <hr>
<form action="filter" method="POST">
	<input type="hidden" name="cat_id" value="{{$key}}">
<label>PRICE</label><br>


	Min Price:
<input type="text" name="min"><br>
	Max Price:
	<input type="text" name="max">

<hr>
<label>something</label>

@foreach($variant as $v)
<hr>
<label>{{$v['variant_name']}}</label>
<span>
	@php
	end($path);
	$key=key($path);
	@endphp
<input type="hidden" name="variant[]" value="{{$v['variant_name']}}">
@foreach($v['value'] as $val)


<input type="checkbox" name="{{$v['variant_name']}}[]" value="{{$val['variant_value']}}">
<button type="button" style="width: 25%"><a href="/api/variant/id={{$key}}&name={{$val['variant_value']}}">{{$val['variant_value']}}</a></button>
@endforeach</span>

@endforeach
<hr>
<label>BRAND</label>

<select  name="brand[]" class="vr form-control chosen-select" multiple tabindex="4" data-id="">
@foreach($brand as $b)
<option value="{{$b->id}}">{{$b->brand_name}}</option>
@endforeach
</select>
@foreach($brand as $b)
<span><input type="checkbox" name="brand[]" value="{{$b->brand_name}}"> {{$b->brand_name}}</span>
@endforeach
<hr>


<label>DISCOUNT</label><br>
 <input type="checkbox" name="discount[]" value="10">10%discount <br>
 <input type="checkbox" name="discount[]" value="20">20%discount <br>
 <input type="checkbox" name="discount[]" value="30">30%discount <br>
 <input type="checkbox" name="discount[]" value="40">40%discount <br>
 
<input type="Submit" name="">
</div>

</form>
<div class="card col-md-8" style="margin-left: 50px"><hr>

	@if(isset($path))

<ul style=" list-style:none;display: flex;">
	
@foreach($path as $key => $value)

<a href="/api/path_data/{{$key}}"><li>{{$value}}</li></a> ->

@endforeach
</ul>
@endif
<div class="row">
	<label style="margin-left: 10px"><strong>Sort By</strong></label>
	<ul style=" list-style:none;display: flex;">
		<div class="popularity"><li>Popularity</li></div>
       <div class="low_high"><li style="margin-left: 50px"><a href="/api/price_asc/{{$key}}">Price -- Low to High</a></li></div>
     <div class="high_low"><li style="margin-left: 50px"><a href="/api/price_des/{{$key}}">Price -- High to Low</a></li></div>
     <div class="newest"><li style="margin-left: 50px"><a href="/api/newest/{{$key}}">Newest First</a></li></div>

	</ul>
</div>
<hr >
@if(isset($product))

@foreach($product as $p)
<div class="row">
<div class="col-md-4">
<ul >
    <b>Product Image</b>

<li>
@php
    $img=unserialize($p->image);
    
     @endphp
     @if(empty($img))
      no Image Uploaded
     @endif    
     
    @foreach($img as $key=>$pic)
     
      
    <img src="/Uploads/Product_images/{{ $pic }}"  height="250" width="150" >
    

    @endforeach

</li>
</ul>
</div>

<div class="col-md-4">
<ul>
	<b>Product Name:</b>
	<a href="/api/product/{{$p->id}}"><li>{{$p->product_name}}</li></a>
	<b>Product Description:</b>
	<li>{{$p->product_description}}</li>
</ul>
</div>
<div class="col-md-4">
<ul>
	<b>Price</b>
	<li>
		<div class="price">
@php $t=1; @endphp
@foreach($offer as $key=>$off)
    @if($key==$p->id)
      {{$p->min_price-$off}}<br>
      <strike>
      {{$p->min_price}}  </strike>	
  @php $t=0; @endphp
  @endif




  @endforeach
		@if($t)
		{{$p->min_price}}
		@endif
		


	
    


		</div>
	</li>
</ul>
</div>
	</div>
<hr>
@endforeach
</div>




@endif


@if(isset($list))
@foreach($list as $value)
{{$value->product_name}}
@endforeach
@endif

</div>

</div>
@endsection


@section('js')
<script>
$(document).ready(function(){
	$('.low_high').on("click",function(){
	alert("price low to high");

});
	$('.high_low').on("click",function(){
	alert("price high_low");

});
});
</script>
@endsection