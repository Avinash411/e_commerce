
  $(document).on('change','.tab_change',function(){
    var changes=$('input[type="radio"]:checked.tab_change').val();
   
    console.log(changes);
   
    $('.nav-tabs a[href="#'+changes+'"]').tab('show');
  
  });

   $(document).on('click','.nav-item',function(){
    var temp=$(this).data('id');
    $('.tab_change').attr('checked',false);
    console.log(temp);
        if($('#sim').val()==temp){
   console.log($('#sim').val());
      $('#sim').attr("checked",true);
    }
    if($('#var').val()==temp){
   console.log($('#var').val());
      $('#var').attr("checked",true);
    }

   });
// $(document).ready(function(){
//   $('.nav-item').click(function(){
//     //alert(this.id);
//     var temp=this.id;
//     console.log(temp);
//     if($('#sim').val()==temp){
//    console.log($('#sim').val());
//       $('#sim').attr("checked",true);
//     }
//     if($('#var').val()==temp){
//    console.log($('#var').val());
//       $('#var').attr("checked",true);
//     }
//     //$(this).unbind();
//     //console.log($('.tab_change radio[value='+temp+']').val());
//     //$('input[name=product_type]', '.tab_change').prop("checked", true);
//      //$("#male").prop("checked", true);
//     //$('input[type="radio"]')
//   });
// });
$(document).ready(function(){

  $('.product_category').trigger('change');

  // to clear data from simple when  user goto add variant part  
  $(".add").click(function(){
    //confirming user want to delete data and if yes the delete it.
    var price=$("input[name='rate']").val();
    
    var sku=$("input[name='sku']").val();
    var img=$("input[name='img[]']").val();
    if(price || sku || img){
    if(confirm("Clear all simple data")){
     $("input[name='rate']").val('');
    
    $("input[name='sku']").val('');
    $("input[name='img[]']").val('');
    }
   }
   // default hide
   

  });


  // making option for user 
	$("#pills-home-tab").click(function(){
       // $("#variant").hide();
       //  $("#simple").show();
       //$('.nav-tabs a[href="#simple"]').tab('show');
    });
    $("#pills-profile-tab").click(function(){
    	// $('#simple').hide();
     // $('#variant').show();
    // $('.nav-tabs a[href="#variant"]').tab('show');
    });
    // click to make combination
    $(".attributes").change(function(){
    var value=$(".attributes").val();
    $(".attributes option[value="+value+"]").attr('disabled',true);

     if(value!='0'){
      $.post("/product/variants",{
     'id':value,
     '_token':$('input[name="_token"]').val()
  },function(data){

  	$("#text").append(data);
  	$('.chosen-select').chosen();
  	
  });
  } 
 });


});

// click to show the combination and input tag after creating combination
$(document).on('click','#attr_button',function(){
      
      var base=[];
      $('.vr').each(function(index,value)
        {  base.push($(this).attr('name'));     });

       var x = {};

         $('.vr').each(function(index,value)
          {  
             if(!x[$(this).attr('name')])
             {
                x[$(this).attr('name')] = {};
             }

            x[$(this).attr('name')] = $(this).val(); });
          
            var keys = Object.keys(x);


    if(keys.length!=0){
      
     $.post("/product/combination",{
     'base':base,
      'arr':x,
      'keys' : keys,
      '_token':$('input[name="_token"]').val()
     },function(data){
      
      $("#combination").html(data);

     });
    }
    });
//click to delete extra combination
$(document).on('click','.del',function(){
  var r=$(this).data('id');
 
  $('#'+r).remove();

});


 $(document).on('change','.product_category',function(){
    
    $('.variants').hide();

    $('.variants'+$(this).val()).show();


  
  });

 $(document).on('change','.product_category',function(){
    
    $('.brand').hide();

    $('.brand'+$(this).val()).show();

  });
