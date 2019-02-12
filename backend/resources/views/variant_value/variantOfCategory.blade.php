<option>Choose Variant</option>
@foreach($variant as $v)
<option value="{{$v->id}}">{{$v->variant_name}}</option>

@endforeach