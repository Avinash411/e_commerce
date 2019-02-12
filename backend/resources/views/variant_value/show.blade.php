
{{--@extends('layouts.app')--}}
@extends('backend.layout')

@section('content')
  
  <div class="card-body">
  <h4 class="card-description">{{ __('All Variant Value Details') }}</h4>
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
      @php
      $arr[0]=$key;
      $arr[1]=$variant_name;
      $temp=implode("&&",$arr);
      @endphp
      <a href="{{route('get:VariantValueController:edit',['id'=>$temp])}}"><span class="fa fa-pencil-square-o"></span></a>
            
<i data-id="{{$temp}}" class="delete" ><span class="fa fa-trash-o" ></span></i>



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
@section('js')
<script>
    $(document).on('click','.delete',function(){
  if(confirm("Are you sure you want to delete!")){
  var id=$(this).data('id');
  $.post("/value/delete",{
    'delete':id,
    '_token':$('input[name="_token"]').val()
  },function(){
     location.reload();
  });
}
});
</script>
@endsection
