@extends('backend.layout')
@section('content')
   <div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
        

      <div class="card-body">
 <h4 class="card-description">{{ __('Enter Brand Details') }}</h4>
            <form method="POST" action="{{route('post:BrandController:store')}}" class="forms-sample">
           @csrf
        <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label">Name</label>
             <div class="col-sm-9">
             <input type="text" class="form-control"  autofocus name="name"value="{{ old('name') }}" autofocus placeholder="Brand Name">
              </div>   
            </div>



            
    
  <div class="form-group row">
    <label for="details" class="col-sm-3 col-form-label">Description</label>
    <div class="col-sm-9">
    <textarea class="form-control" name="details" value="{{ old('details') }}" rows="3" placeholder="Brand Description"></textarea>
  </div>
  </div>

  <div class="form-group row">
    <label for="category" class="col-sm-3 col-form-label">Refere Category </label>
   <div class="col-sm-9">
      <select  name="category[]" class="chosen-select form-control col-sm-9"  multiple>
                                    
       
        @foreach($category as $c)
    <option value="{{$c->id}}">{{$c->category_name}}</option>
                                
         @endforeach

      </select>
      </div>
  </div>
  


  <div class="form-group row mb-0">
     
      <button type="submit" name="save" class="btn btn-success mdi mdi-check " value="save">
         {{ __('Save') }}</button>
     
     
     <button type="submit" name="save_and_more" class="btn btn-primary mdi mdi-file-document" value="add">
      {{ __('Add more') }}</button>

       <a href="{{route('get:BrandController:show')}}"><button type="button"  name="cancel" class="btn btn-secondary mdi mdi-refresh" value="can">
    {{ __('Cancel') }}</button></a>
     

      </div>
    


   

</form>




</div>
</div>
</div>
</div>
</div>
@endsection

@section('css')
<style>
  .card .card-body{
    height: 700px;
  }
</style>
@endsection

