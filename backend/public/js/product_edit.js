$(document).on('click','#new_add',function(){

 $.post("/product/new_add",{
     
      'keys' : keys,
      '_token':$('input[name="_token"]').val()
      
     },function(data){
      
      $("#new_add").html(data);

     });
});
