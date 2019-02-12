{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" >
            <div class="card-body">
         <h4 class="card-description">{{ __('Enter Product Details') }}</h4>

      <div class="card-body">

   			<form method="POST" action="{{route('post:ProductController:store')}}" enctype="multipart/form-data">
        @csrf
  		<div class="form-group ">
   		 <label for="name">Product Name</label>
   			 <input type="text" class="form-control" name="name" placeholder="Product Name" value="{{ old('name') }}" required>
   				 
  			</div>
  			<div class="form-group">
  	
  <div class="form-group">
    <label for="details">Product Description</label>
    <textarea class="form-control" name="details" rows="3" placeholder="Product Description" >{{{ old('details') }}}</textarea>
  </div>
  <div class="form-group">
    <label for="picture">Image</label>
    <input type="file" class="form-control-file" name="picture[]" multiple="multiple">
    <small id="fileHelp" class="form-text text-muted">choose only jpg,png.</small>
  </div>
<fieldset class="form-group">
    <label>Choose Product Category</label>
    <div class="form-group">
      
        <select name="category" class="product_category chosen-select form-control">
         @foreach($category as $c)

          <option value="{{$c->id}}">{{$c->category_name }}</option>
          @endforeach
        </select>

    </div>
  </fieldset>



  <fieldset class="form-group">
    <label>Choose Brand</label>
    <div class="form-group">
      
        <select name="brand" class="form-control">
          <option value="">Choose brand</option>
          @foreach($brand as $b)
          
        	<option value="{{$b->id}}" class="brand brand{{$b->category_id}}">{{$b->brand_name }}</option>
          @endforeach
        </select>
    </div>
  </fieldset>
  
  <input type="radio" name="product_type"  class="tab_change" value="simple" id="sim" checked>Simple
  <input type="radio" name="product_type" class="tab_change" value="variant" id="var">Add Variant

  <ul class="nav-tabs nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item active " data-id="simple">
    <a class="add nav-link active" id="pills-home-tab" data-toggle="pill" role="tab" href="#simple" aria-controls="pills-home" aria-selected="true">Simple</a>
  </li>
  <li class="nav-item" data-id="variant">
    <a class="add nav-link" id="pills-profile-tab" data-toggle="pill" href="#variant" role="tab" aria-controls="pills-profile" aria-selected="false">Add Variant</a>
  </li>
  
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="simple" role="tabpanel" aria-labelledby="pills-home-tab">

    Price:<input type="number" name="rate" class="form-control"><br><br>

     SKU:<input type="text" name="sku" class="form-control">
     <small>SKU must be unique.</small><br><br>
     Quantity <input type="number" name="quantity" class="form-control"><br><br>
     Simple Image:<input type="file" name="img[]" multiple="multiple"><br>
      <small id="fileHelp" class="form-text text-muted">choose only jpg,png.</small>
     </div>
  <div class="tab-pane fade" id="variant" role="tabpanel" aria-labelledby="pills-profile-tab">
   
    <label>Choose Variant</label>
  <select name="variant" class="attributes form-control">
    
    <option value="0">choose</option>
  @foreach($variants as $v)
  <option value="{{$v->id}}" class="variants variants{{$v->category_id}}">{{$v->variant_name}}</option>
  @endforeach
</select>
<div id="text">
  
</div>

  <button type="button" class="btn btn-info" id="attr_button" >Save Attribute</button>

<div id="combination"></div>
</div>
  
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...sdfff</div>
</div>



  <div class="form-group row mb-0" >
     
      <button type="submit" name="save" class="btn btn-success mdi mdi-check " value="save">
         {{ __('Save') }}</button>
     
     
     <button type="submit" name="save_and_more" class="btn btn-primary mdi mdi-file-document" value="add">
      {{ __('Add more') }}</button>

       <a href="{{route('get:ProductController:show')}}"><button type="button"  name="cancel" class="btn btn-secondary mdi mdi-refresh" value="can">
    {{ __('Cancel') }}</button></a>
     

      </div>

</form>


</div>
</div>
</div>
</div>
</div>
@endsection
@section('js')

<script  src="{{asset('js/variants.js')}}"></script>
@endsection