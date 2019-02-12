

{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')
<div class="card-body">

  <h4 class="card-description">{{ __('Restore Brand Details') }}</h4>
<table class="table table-striped table-bordered">
	<tr>
		<th>Brand Name</th>
		<th>Brand Description</th>
        <th>Refere Category ID</th>
		<th>Action</th>
	</tr>
	@foreach($brand as $key => $b)
  
    <tr>
      <td>{{ $key}}</td>
      <td style="max-width: 350px">{{ $b[0]->brand_description}}</td>
        <td>
          <ul>
          @foreach($b as $categories)
          <li>
          {{ $categories->category->category_name }}
          </li>
          @endforeach
          </ul>
        </td>
        
  
    	<td>
        <form method="POST" action="{{route('post:BrandController:DeletedDataStore')}}">
          @csrf
          <input type="hidden" name="id" value="{{$b[0]->id}}">
          <input type="Submit" name="" value="Restore" class="btn btn-primary">

        </form>

        </td>
    </tr>
     @endforeach

</table>
</div>



@endsection
