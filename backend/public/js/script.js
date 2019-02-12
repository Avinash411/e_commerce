$(document).ready(function(){
	// its for product image 
  $("#remove").click(function(){

  if($("input[name='remove[]']:checked").length>0){
   

	//console.log($("input[name='remove[]']:checked").length);   

    $.each($("input[name='remove[]']:checked"),function(index,value){

			$('#image_form').append([value]);

    	});

    		$('#image_form').submit();

    }
 
 	});
  //its for variants image
 

 

});

//its for image remove data from variant part
$(document).ready(function(){

	$(".variant_image_remove").click(function(){
    

var i=$(this).data('id');
  if($("input[name='variant_image_remove["+i+"][]']:checked").length>0){
   


    $.each($("input[name='variant_image_remove["+i+"][]']:checked"),function(index,value){
    
			$('#variant_image_form').append([value]);

    	});
    

    		$('#variant_image_form').submit();
    		

    }
    

 
 	});
});
//new variant adding in edit product part in individual product
$(document).on('click','#new_add',function(){

 $.post("/product/new_add",{
    
     '_token':$('input[name="_token"]').val(),
     'id' : $(this).data('id')
     },function(data){
      var temp=$(".showing").data('id');
      var ttemp=$("input[name='com["+temp+"]']").val();
      if(ttemp==''){
      $("#add_value_variants").html("This is simple product.If you wants to select option for new variant of product then you have to update your previous variant details of product by selecting appropriate option for particular variant.");
      }
      $("#add").append(data);
      
     });
});
//delete new variant box if its is not relevent
$(document).on('click','.del-added',function(){
  var r=$(this).data('id');
  
  $('.'+r).remove();

});
//delete existing veriant 
$(document).on('click','.delete_variant',function(){
  if(confirm("Are you sure you want to delete!")){
  var id=$(this).data('id');
  $.post("/product/delete_variant",{
    'id':id,
    '_token':$('input[name="_token"]').val()
  },function(){
    $('#variation_id'+id).remove();
  });
}
});

$(document).on('change','.product_category',function(){
    
    $('.brand').hide();

    $('.brand'+$(this).val()).show();

  });



$(document).ready(function(){
    
    $('.brand').hide();

    $('.brand'+$('.product_category').val()).show();

  });
  $(document).on('change','.v_option',function(){
    
    var x= '';
     var id= $(this).parent().data('id');
     $.each($(this).parent().find('.v_option'),function(index,value){
    
        if($(this).val()!='')
        x += '-'+$(this).val();

    	});
     // x=x.replace("'/'^'\'s+|'\'s+$'/'gm",'-');
     x=x.substr(1);
      $("input[name='com["+id+"]']").val(x);

  });
 //
 
//  $(document).ready(function(){
    
//   $('.selected_data').hide();

//   $('.showing').click(function(){
//     $('.selected_data').show();
//   })

// });