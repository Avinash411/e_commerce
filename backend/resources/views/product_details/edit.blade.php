{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
         <div class="card-description">{{ __('Edit Product Details') }}</div>

      <div class="card-body">

   			<form method="POST" action="{{route('post:ProductController:update')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$product->id}}">
  		<div class="form-group ">
   		 <label for="name">Product Name</label>
   			 <input type="text" class="form-control" name="name" placeholder="Product Name" value="{{$product->product_name}}">
   				 
  			</div>
  			<div class="form-group">
  	
  <div class="form-group">
    <label for="details">Product Description</label>
    <textarea class="form-control" name="details" rows="5"col='50' placeholder="Product Description" >{{$product->product_description}}</textarea>
  </div>
  <div class="form-group">
    <label for="picture">Image</label><br>
    
    @php
    $img=unserialize($product->image);
    
     @endphp
     @if(empty($img))
      no Image Uploaded
     @endif    
     
    @foreach($img as $key=>$pic)
     
      <input type="checkbox" name="remove[]"  style="position: absolute;" value="{{$key}}">
    <img src="/Uploads/Product_images/{{ $pic }}"  height="150" width="150" >
    

    @endforeach
        
    <br><button type="button" class="btn btn-secondary" style="margin-top: 10px" id="remove">Remove</button>
    <br><label for="picture">Choose Image</label><br>
   
    <input type="file" class="form-control-file" style="margin-left: 70px " name="picture[]" value="" multiple="multiple">
    <small id="fileHelp"  style="margin-left: 70px" class="form-text text-muted">choose only jpg,png.</small>

  </div>
  
  <fieldset class="form-group">
    <label>Choose Product Category</label>
    <div class="form-group" style="margin-left: 70px">
      
        <select name="category" class="product_category chosen-select form-control">
        

          <option value="{{$product->category_id }}">{{$product->category->category_name }}</option>
          @foreach($allcategory as $c)
          <option value="{{$c->id }}">{{$c->category_name }}</option>
          @endforeach
        
        </select>
        <small>if you want to change category then you variant of repected category then first you have to change category then save then you open same 
        product then have all variant of exieting category.</small>
    </div>
  </fieldset>
  <fieldset class="form-group">
    <label>Choose Brand</label>
    <div class="form-group" style="margin-left: 70px">
      
        <select name="brand" class="form-control">
         
          
          <option value="{{$product->brand_id}}">{{$product->brand->brand_name }}</option>
         @foreach($allbrand as $b)
          <option value="{{$b->id }}" class="brand brand{{$b->category_id}}">{{$b->brand_name }}</option>
         @endforeach
        </select>
    </div>
  </fieldset>
  <label ><b>Choose Product variants</b></label>
  <button type="button" id="new_add" data-id="{{$product->id}}" style="margin-left: 400px;" class="btn btn-primary">New Add</button>
  <div id="add_value_variants" style="color:red;"></div>
  <div id="add">
    
  </div>
  <div class="tep">
  @foreach($variant as $v)
  
  <div class="container" style="border: 1px solid #ddd;box-shadow:0px 0px 10px lightgray;border-radius:10px; margin-top:20px;" id="variation_id{{$v->id}}">

  <fieldset class="form-group" style="">
    <div class="form-group" style="margin-top: 25px;">

      <label class="showing" data-id="{{$v->id}}">Choosen Varinats </label>
      {{--<small>if you have to see or change varinat then you have to click on Choosen Varinats</small>
      --}}<br>
      <div class="selected_data"data-id="{{$v->id}}">
      @foreach($variant_com as $vari)
      <label for=""><b>{{$vari->variant_name}} : </b></label>
      
      <select name="value[{{$v->id}}][][{{$vari->id}}]" id=""class="form-control v_option">
      <option value="">none</option>
      @foreach($value as $vall)
      @if($vall->variant_id==$vari->id)
      @php $temp=0; @endphp
      @foreach($details as $d)
        @if(($d->product_variant_id)==$v->id && $d->value_id==$vall->id)
        @php $temp=$d->value_id; @endphp
      <option value="{{$vall->variant_value}}" selected>{{$vall->variant_value}}</option>
        @endif  
        @endforeach
       @if($vall->id != $temp)
        <option value="{{$vall->variant_value}}">{{$vall->variant_value}}</option>
        @endif
        @endif
       @endforeach
       </select>

      @endforeach
      </div>


    {{--  @foreach($details as $d)

      @if(($d->product_variant_id)==$v->id)

      
       <select name="value[{{$v->id}}][{{$d->id}}]">
        
      @foreach($value as $val)

      @if(($d->value_id)==$val->id)
      
        <option value="{{$val->variant_value}}" selected>{{$val->variant_value}}</option>
        @php


       $temp=$val->id;
       @endphp
        @else
        <option value="{{$val->variant_value}}">{{$val->variant_value}}</option>

      

      @endif

      @if((($d->value['variant_id'])==$val->variant_id) && ($temp!=$val->id))

      <option value="{{$val->variant_value}}">{{$val->variant_value}}</option>
      @endif
      

      @endforeach

      </select>

      @endif

      @endforeach 

      --}}
    
      <label >Combination</label>
      <input type="text"  name="com[{{$v->id}}]" value="{{$v->combination}}" readonly class="form-control"><br>
      <input type="hidden" name="product_type" value="@if($v->combination=='') simple @else variant_type @endif">
      <label>Price</label>
      <input type="number" name="price[{{$v->id}}]" value="{{$v->price}}" class="form-control" required><br>
      <label>SKU</label>
      <input type="text" name="sku[{{$v->id}}]" value="{{$v->stock_keeping_unit}}" class="form-control" required><br>
      <label>Quantity</label>
      
       @if(isset($v->getCurrentStock[0]))
       <input type="number" name="quantity[{{$v->id}}]" value="{{$v->getCurrentStock[0]->quantity}}" class="form-control"><br>
       @else
       <input type="number" name="quantity[{{$v->id}}]" value="0" class="form-control"><br>
       @endif       
      
      <label>Uploaded Image</label><br>
      @php 
      $pics=unserialize($v->image);
      $j=0;
  
            @endphp
      @if(empty($pics))
      no Image Uplaoded
      @endif
       @foreach($pics as $keys=>$p)
       

      <input type="checkbox" name="variant_image_remove[{{$v->id}}][]"  style="position: absolute;" value="{{$keys}}">
    <img src="/Uploads/Variants_image/{{ $p }}"  height="150" width="150" >
    

    @endforeach
        
    <br><button type="button" class="variant_image_remove btn btn-secondary" data-id={{$v->id}} style="margin-top: 10px" >Remove</button> 
    <br><label for="picture">Choose Image</label><br>
   
    <input type="file" class="form-control-file" style="margin-left: 2px " name="variant_image[{{$v->id}}][]" value="" multiple="multiple">
    <small id="fileHelp"  style="margin-left: 70px" class="form-text text-muted">choose only jpg,png.</small>
     <button type="button" style="float: right;" class="delete_variant btn btn-danger" data-id="{{$v->id}}" >remove</button>
    </div>
 
  </fieldset>

 </div>
    
  @endforeach
  </div>
  <div class="form-group row">
    <div class="col-md-4">
  <button type="submit" class="btn btn-success" style="margin-left: 100px; margin-top:20px;"><span class="fa fa-check"></span>Save</button></div>
  <input type="reset" value="Reset" onClick="window.location.reload()" style="margin-left: 250px;margin-top:20px;" class="fa fa-undo btn btn-secondary ">
</div>
</form>

</div>
</div>
</div>
</div>
</div>
<form method="POST" action="{{route('post:ProductController:remove_image_edit_process')}}" id="image_form"> 
  @csrf
   <input type="hidden" name="id" value="{{$product->id}}">
  
  
</form>
<form method="POST" action="{{route('post:ProductController:variant_image_remove')}}" id="variant_image_form"> 
  @csrf
   
  
  
</form>

@endsection
@section('js')

<script src="{{asset('js/script.js')}}"></script>
@endsection