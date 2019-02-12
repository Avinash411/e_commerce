@php $rnd=rand(); @endphp

<div class="{{$rnd}}" style="border: 1px solid #ddd;box-shadow:0px 0px 10px lightgray;border-radius:10px; margin-top:20px;padding:20px 0px;">
	<div class="container" >
  <label>Choose Variants</label><br>
  <div class="selected_data"data-id="{{$rnd}}">
  @foreach($variant as $vari)
   @if(!empty($vari))
  
    <label for="add[variant][{{$rnd}}][]"><b>{{$vari->variant_name}} : </b></label>
    <select name="add[variant][{{$rnd}}][][{{$vari->id}}]" class="form-control v_option">
    <option value="">None</option>	
    @foreach($value as $v)
    @if($vari->id == $v->variant_id)
   
   
    <option value="{{$v->variant_value}}">{{$v->variant_value}}</option>
    
  @else  
  
    @endif
    @endforeach
    </select>
   @endif
  @endforeach	
</div>
  <br><br>
  Combination
  <input type="text" name="com[{{$rnd}}]" readonly class="form-control">
  Price <input type="number" name="add[price][{{$rnd}}]" class="form-control" required>

  <br>
  SKU <input type="text" name="add[sku][{{$rnd}}]" class="form-control" required>
  <small>SKU must be unique.</small><br>
Quantity <input type="number" name="add[quantity][{{$rnd}}]" class="form-control"><br> 
  Choose Image <input type="file" name="add[image][{{$rnd}}][]" multiple="multiple"><br>
  <small id="fileHelp" class="form-text text-muted">choose only jpg,png.</small>


	<div class="" style="text-align:right;">
  <button type="button" class="del-added btn btn-danger" data-id="{{$rnd}}">Remove</button>
</div>
</div>

</div>