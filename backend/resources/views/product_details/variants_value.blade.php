<div class="row variant_values col-lg-12">

<div class="col-lg-3">
	
<input type="text" value="{{$variant->variant_name}}"disabled>
<input type="hidden" name="variant[]" value="{{$variant->variant_name}}">
</div>

<div class="col-lg-4">
<select  name="{{$variant->variant_name}}" class="vr form-control chosen-select" multiple tabindex="4" data-id="{{$variant->variant_name}}">
@foreach($value as $v)
<option value="{{$v->variant_id}}_{{$v->variant_value}}">{{$v->variant_value}}</option>
@endforeach
</select>


</div>

</div>