import { element } from 'protractor';
import { AnglaraService } from './../../sevices/anglara.service';
import { ActivatedRoute, Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';
import * as $ from 'jquery';
import { empty } from 'rxjs';
import { TokenService } from 'src/app/sevices/token.service';
import { SnotifyService } from 'ng-snotify';
@Component({
  selector: 'app-product-details',
  templateUrl: './product-details.component.html',
  styleUrls: ['./product-details.component.css']
})
export class ProductDetailsComponent implements OnInit {

  constructor(
    private router:ActivatedRoute,
    private anglara:AnglaraService,
    private route:Router,
    private Token:TokenService,
    private notify:SnotifyService
 
  ) { }
  public imgBaseUrl="http://localhost:8000/Uploads/Product_images/";
  public VariantimgBaseUrl="http://localhost:8000/Uploads/Variants_image/";
  public key:any;
  public path:any;
  public arr:any;
  public root:any;
  public mydata:any;
  public variant:any;
  public typeforcompare:any;
  public price:any;
  public variant_id:any;
  public discount:any;
  public quantity:any;
  public actual_price:any;
  public types:any;
  public variant_image:any;
  public form1={
    type:null,
    user:null,
    quantity:null,
   
    
    token:null
   
  };
  public formlist={
    type:null,
    user:null,
    //quantity:null,
   
    
    token:null
   
  };
  //public final_arr:any;
  public backend_combination:any;
  ngOnInit() {
    this.router.paramMap.subscribe(
      params=>{
      let item=params.get('search');
    console.log(item);
    //this.form.search=item;
    this.getproductdetails(item);
      });

     $(document).ready(function(){

      console.log('ddd');
      $(document).on('mouseover','.variant_image',function(){
        console.log('in');
        $('#large_image').attr('src',$(this).attr('src'));

      });
    });
  }
  getproductdetails(data){
    this.anglara.getProductdetails(data).subscribe(
  
     
      data=>this.handleResponse(data)
    )
  }
  handleResponse(data){
    this.path=data.path;
    this.mydata=data.data;
    console.log("my data");
    console.log(this.mydata.photo);
    this.variant=data.data.variants;
 //this.variantForCart=this.variant;
    this.root=Object.keys(this.path.root).map(key=>({type:key,value:this.path.root[key]}));
    this.key=this.root[this.root.length-1]['type'];
    this.types=data.variant_value;
   this.types=Object.keys(data.variant_value).map(key=>({type:key,value:data.variant_value[key]}));
   for (const {type, index} of this.types.map((type, index) => ({ type, index }))) {
    //console.log(type); // 9, 2, 5
    let temp=this.types[index]['value'];
    if(temp!=null)
    temp=Object.keys(temp).map(key => ({type: key, value: temp[key]}));

    //console.log(this.types[index]['value']);
    for (const {type, index} of temp.map((type, index) => ({ type, index }))) {
    let tempy=temp[index]['value'];
    if(tempy!=null)
    tempy=Object.keys(tempy).map(key => ({type: key, value: tempy[key]}));
    temp[index]['value']=tempy;
    }
    this.types[index]['value']=temp;
    // let tempy=this.types[index]['value'];
    // if(tempy!=null)
    // tempy=Object.keys(tempy).map(key => ({type: key, value: tempy[key]}));

    // //console.log(this.this.types[index]['value']);
    // this.types[index]['value']=tempy;
    // //this.dam= Object.keys(this.this.types).map(key => ({type: key, value: this.dam[key]}));
    //console.log(this.temp);
    ///console.log(index); // 0, 1, 2
  } 
  
   
    this.variant=Object.keys(this.variant).map(key=>({type:key,value:this.variant[key]}));
    console.log(this.variant);
    this.price=this.variant[0]['value'].price;
    this.variant_id=this.variant[0]['value'].variants_id;
    this.quantity=this.variant[0]['value'].quantity;
    this.discount=this.variant[0]['value'].rates.discount_in_percentage;
    this.actual_price=this.variant[0]['value'].rates.actual_price;
    //console.log(this.price);
   
    console.log("g");
    let array_img=[];
    for(const{type,value} of this.variant){
      //console.log(value.type_image);
      let tempry=value.type_image;
      if(tempry.length>0){
      for(let tt=0;tt<tempry.length;tt++){
     // console.log(tempry[tt]);
     array_img.push(tempry[tt]);
      }
    }
    }
    this.variant_image=array_img;
   console.log(this.variant_image);
   
  }
  get_data(event) {
    console.log("data property");
    console.log(event.target.dataset.variant_id);
    this.price=event.target.dataset.price;
    this.variant_id=event.target.dataset.variant_id;
    this.quantity=event.target.dataset.quantity;
    this.discount=event.target.dataset.discount;
    this.actual_price=event.target.dataset.actual_price;
 }
 getValueForCheckCombination(event){
  
   let type=event.target.dataset.element;
   let selected=[];
let unselected=[];
   
     
   //console.log(event.target.dataset.element);
   
  //var final_arr:[];
  let count=0;
   for(const{type,value} of this.variant){
     
     let arr=value['type'].split('-');
     let id=value['variants_id'];
     //console.log(value['rates']['sale_price']);
    // for (let i = 0; i < arr.length; i++) { 
      




    if($.inArray(event.target.dataset.element, arr) !== -1){  
      //console.log(id);
      if(count==0){
        this.price=value['rates']['sale_price'];
        //console.log(this.price);
         this.variant_id=value['variants_id'];
         this.quantity=value['quantity'];
         this.discount=value['rates']['discount_in_percentage'];
         this.actual_price=value['rates']['actual_price'];
          //this.getpricedeatails(id);
        //console.log(this.quantity);
        console.log("one time");
       // console.log(value);
       //this.variant=[];
       let array_img=[];
    
      //console.log(value.type_image);
      let tempry=value.type_image;
      if(tempry.length>0){
      for(let tt=0;tt<tempry.length;tt++){
     // console.log(tempry[tt]);
     array_img.push(tempry[tt]);
      
    }
    }
    this.variant_image=array_img;
    let imag=this.imgBaseUrl;
    $(document).ready(function(){
    $('.default').remove();
    //console.log($('#no_image').attr('src'));
    if($('.variant_image:first').length!=0)
    $('#large_image').attr('src',$('.variant_image:first').attr('src'));
    else
    $('#large_image').attr('src',imag+'no_image.jpg');

    });
        //this.variant[0]['type']=type;
         //this.variant[0]['value']=value;
         //this.variant[]
         
        //console.log(this.variant);
        //break;
        //for(const{})
        count++;
      }
    
      // console.log(this.price);
      for (let i = 0; i < arr.length; i++) { 
      
     // if(event.target.dataset.element !=arr[i]){
    //selected.push(arr[i]);
    if(selected.indexOf(arr[i]) == -1){
      selected.push(arr[i])
  }
      $(document).ready(function(){
        // let varinat=
        $('.d_'+arr[i]).addClass('add_forselected');

      
     });
    

     // }
      
      
      
      }
    }
    let temp=[];
    if($.inArray(event.target.dataset.element, arr) == -1){   
     //console.log(arr);
     
      $(arr).each(function(index,value){
        //unselected.push(value);
        if(unselected.indexOf(value) == -1){
          unselected.push(value)
      }
          //$('.d_'+value).removeClass('add_selected');
     
       
      });
      
    }
     //unselected = temp.map(function(v,i) { return (v - selected[i]); }); 
 //temp=unselected;
 //unselected.filter(n => !selected.includes(n));
   
    // }
    // console.log(type);
    // console.log(arr);
    // console.log($.inArray(event.target.dataset.element, arr));
     //if(temp==)
     //console.log(this.final_arr);
    
    }
    let final_arr=[];
    for(let i=0;i<unselected.length;i++){
    if(selected.indexOf(unselected[i])==-1){
      final_arr.push(unselected[i]);
     // if(!$('.d_'+unselected[i]).hasClass('add_selected'))
      $('.d_'+unselected[i]).removeClass('add_selected')
      $('.d_'+unselected[i]).removeClass('add_forselected')

    }
    }
    $(document).on('click','.d_'+type,function(){
     // $('.variant_block').removeClass('add_forselected');
          $(this).parent().find('li').removeClass('add_selected');
      //  if(selected.indexOf($(this).val())!=-1){
         $(this).addClass('add_selected');
      //  
    //}
    // $(selected).each(function(index,value){
    //   //unselected.push(value);
    //   let temp=value;
    //   if($(this).val())==temp)){

    //   }else{
    //   $('.d_'+value).addClass('add_forselected');
    //   }
     
    // });
    


      
 });
    console.log("selected");
    console.log(selected);
    console.log("unselected");
    console.log(final_arr);
    
 }
 add_to_cart(){
   //get valid data form add_selected class  like first use has to select data then check 
   //if combination is availble or not  if yes then pass the data like only variant 
   //id and do not woryy about user id and qauntity will 1 default
  this.typeforcompare=this.getselectedcombination();
 console.log(this.typeforcompare);
 let user=0;
 this.form1.type=this.typeforcompare;
    this.form1.user=user;
    this.form1.quantity=1;
   
    this.form1.token=this.Token.get();
this.anglara.storeInCart(this.form1).subscribe(

//data=>console.log(data)
//data=>this.handleCartResponse(data)
data=>this.handleCartResponse(data),
error=>this.notify.error(error.error.Response.message)
)

 
    //  console.log("search_com");
   // console.log(value['type']);
  
  //  $(document).ready(function(){
    
  
  //   $.post("/",{
      
  //     '_token':$('input[name="_token"]').val(),
  //     'type':value['variants_id']
  //   },function(){
     
  //   });
  
  // });
 
   //this.route.navigateByUrl('/cart/'+308);
 }
 handleCartResponse(data){
  
  this.arr=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  
  this.notify.success(this.arr[0]['value'],{timeout:0});
}
 getselectedcombination(){
  let search_com;
  let arr=[];
  let err_count = 0;
   //$(document).ready(function(){
    //console.log("hii");
    if($('.add_forselected').length>0 )
    {
      
      $('.add_forselected').each(function(){
        if(!$(this).hasClass('add_selected') && !$(this).parent().hasClass('required_field'))
        { 
          err_count++;
          $(this).parent().addClass('required_field').append('<p style="color:red">Required</p>');

        }
        else
        $(this).parent().removeClass('required_field').find('p').remove();

      });
      if(err_count>0)
      throw new Error('err');
    }
      
    $('.add_selected').each(function(index,value){
     
     arr.push($(this).data('element'));
      
     
    });
   search_com=arr.join("-");
  //  this.typeforcompare=search_com;
 // console.log(arr);
  //console.log("in method")
//console.log(search_com);
   //  });
     let id;
     for(const{type,value} of this.variant){
      //console.log(this.typeforcompare)
         if(value['type']==search_com){
           id=value['variants_id'];
         }
        }
    //      console.log("out");
    //  console.log(search_com);
     // console.log(Window.search_com);
     return id;
 }
 add_to_wishlist(){
  //this.route.navigateByUrl('/wishlist/'+308);
  let user=0;
  let item=this.getselectedcombination();
  this.formlist.type=item;
  this.formlist.user=user;
  //this.formlist.quantity=1;
 
  this.formlist.token=this.Token.get();
this.anglara.storeInWishlist(this.formlist).subscribe(

//data=>console.log(data)
//data=>this.handleCartResponse(data)
data=>this.handlewishlistResponse(data),
error=>this.notify.error(error.error.Response.message)
)
 }
 handlewishlistResponse(data){
  
  this.arr=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  
  this.notify.success(this.arr[0]['value'],{timeout:0});
}
 getpricedeatails(data){
  console.log("the data");
  console.log(data);
  console.log(this.variant);

  //this.variant=Object.keys(this.variant).map(key=>({type:key,value:this.variant[key]}));
    // console.log(this.variant);
    //for()
    // this.price=this.variant[0]['value'].price;
    // this.variant_id=this.variant[0]['value'].variants_id;
    // this.quantity=this.variant[0]['value'].quantity;
    // this.discount=this.variant[0]['value'].rates.discount_in_percentage;
    // this.actual_price=this.variant[0]['value'].rates.actual_price;
 }
}
