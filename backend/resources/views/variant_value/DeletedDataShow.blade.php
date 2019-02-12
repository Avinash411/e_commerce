
{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')
  <div class="card-body">
  <h4 class="card-description">{{ __('Restore Value Details') }}</h4>
<table class="table table-striped table-bordered">
  <tr>
    <th>Refer Category</th>
    <th>Variant Name</th>
        
    <th>Variant Value</th>
    <th>Action</th>
  </tr>

  @foreach($cat as $key=>$variant_arr)
  
  @php
  $first = 1;
  
  @endphp

  @foreach($variant_arr as $variant_name=>$variant_values)

   @php
  $sec = 1;
  $last=1;
  @endphp

    @if(is_array($variant_values))
     
      @foreach($variant_values as $values)

    

    <tr id="product_part{{$key}}">
    
    @if($first==1)
    <td rowspan="{{ $variant_arr['count']}}">{{$key}}</td>

    @php
  $first = 0;
  @endphp
    @endif

    @if($sec==1)
    <td rowspan="{{count($variant_values)}}">
    {{ $variant_name }}</td>
    @php
  $sec = 0;
  @endphp
    @endif    
    

    <td>{{ $values->variant_value }}</td>
    
    @if($last==1)
    <td rowspan="{{count($variant_values)}}">
           
<form method="POST" action="{{route('post:VariantValueController:RestoreData')}}">
          @csrf
          <input type="hidden" name="category" value="{{$key}}">
          <input type="hidden" name="id" value="{{ $variant_name }}">
          <input type="Submit" name="" value="Restore" class="btn btn-primary">
        </form>


    </td>
     @php
  $last = 0;
  @endphp
    @endif

  </tr>
  
 

  @endforeach
  @endif
  @endforeach
 
 
  @endforeach

</table>
  </div>





@endsection
