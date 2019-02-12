{{--@extends('layouts.app')--}}
@extends('backend.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card-body">
                <h4 class="card-description">{{ __('Enter All Variants Value') }}</h4>

                <div class="card-body">
                    <form method="POST" action="{{route('post:VariantValueController:store')}}">
                         @csrf

<div class="form-group row">
                 <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Choose Refer Category') }}</label>

                            <div class="col-md-6">
        <select class="chosen-select form-control category">
                  @foreach($category as $cat)
         <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                   @endforeach
                     </select>

                            </div>
                        </div>
                        

<div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Choose Refer Variant') }}</label>

         <div class="col-md-6">
         <select name="variant"class=" form-control attribute chosen-select">
       
          <option>Choose Variant</option>
       
             </select>

            </div>
            </div>
                        

      <div class="form-group row">
             <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Variant Value Name') }}</label>

         <div class="col-md-6">
           <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus placeholder="Variants Name" required>
         <small>Enter all variant value or multiple value with comma separated(,)</small>

             </div>
              </div>

                        

    <div class="form-group row mb-0" >
     
      <button type="submit" name="save" class="btn btn-success mdi mdi-check " value="save">
         {{ __('Save') }}</button>
     
     
     <button type="submit" name="save_and_more" class="btn btn-primary mdi mdi-file-document" value="add">
      {{ __('Add more') }}</button>

       <a href="{{route('get:VariantValueController:show')}}"><button type="button"  name="cancel" class="btn btn-secondary mdi mdi-refresh" value="can">
    {{ __('Cancel') }}</button></a>
     

      </div>

         </form>
            
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('.category').change(function(){

            var cat=$(this).val();
            console.log(cat);
    if(cat){
      $.post("/value/variantOfCategory",{
     'id':cat,
     '_token':$('input[name="_token"]').val()
  },function(data){

    $(".attribute").html(data);
    $(".attribute").trigger('chosen:updated');
    
    
  });
  } 
        });

    })
</script>
@endsection