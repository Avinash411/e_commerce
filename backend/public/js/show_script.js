// product delete part
$(document).on('click','.delete',function(){
  if(confirm("Are you sure you want to delete!")){
  var id=$(this).data('id');
  $.post("/product/show/delete",{
    'id':id,
    '_token':$('input[name="_token"]').val()
  },function(){
    $('#product_part'+id).remove();
  });
}
});
