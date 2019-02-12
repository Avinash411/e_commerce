import { element } from 'protractor';
import { TokenService } from 'src/app/sevices/token.service';
import { AnglaraService } from './../../sevices/anglara.service';
import { ActivatedRoute, Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';
import { SnotifyService } from 'ng-snotify';
import * as $ from 'jquery';
@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {
  public arr:any;
  public card:any;
  public VariantimgBaseUrl="http://localhost:8000/Uploads/Variants_image/";
  public form1={
    type:null,
    user:null,
    quantity:null,
   
    
    token:null
   
  };
  public showall={
    
    token:null
   
  };
  public removedata={
    type:null,
    token:null,
    user:null
   
  };
  public editdata={
    type:null,
    token:null,
    user:null,
    quantity:null
   
  };
  constructor(
    private router:ActivatedRoute,
    private anglara:AnglaraService,
    private Token:TokenService,
    private notify:SnotifyService,
    private route:Router
  ) {
   
   }

  ngOnInit() {
  //   this.router.paramMap.subscribe(
  //     params=>{
  //     let item=params.get('item');
  //     //console.log("cart");
  //   //console.log(item);
  //   //let zero=false;
  //   let user=0;
    
  //   if(item!='0'){
  //     this.store_in_cart(item,user);
  //   } else{
this.show_cart_details();
  // }
    
  //   //this.form.search=item;

  //   //this.store_in_cart(item);
  //     });
      
    
  }
//   store_in_cart(item,user){
//     this.form1.type=item;
//     this.form1.user=user;
//     this.form1.quantity=1;
   
//     this.form1.token=this.Token.get();
// this.anglara.storeInCart(this.form1).subscribe(

// //data=>console.log(data)
// //data=>this.handleCartResponse(data)
// data=>this.handleCartResponse(data),
// error=>this.notify.error(error.error.error)
// )

//  }
// handleCartResponse(data){
  
//   this.arr=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  
//   this.notify.success(this.arr[0]['value'],{timeout:0});
// }
show_cart_details(){
  console.log("hh");
  this.showall.token=this.Token.get();
  this.anglara.showAllCartdata(this.showall).subscribe(

    //data=>console.log(data)
    //data=>this.handleCartResponse(data)
    data=>this.handleAllDataOfCartResponse(data),
    error=>this.notify.error(error.error.error)
    )
}
handleAllDataOfCartResponse(data){
  console.log("this.card");
  console.log(data);  
this.card=data.data[0];
//this.card=Object.keys(data.data[0]).map(key=>({type:key,value:data.data[0]['key']}));
console.log(this.card);

}
remove(event){
  console.log("Remove");
  //console.log(data);
  this.removedata.token=this.Token.get();
  this.removedata.type=event.target.dataset.element;
  this.removedata.user=0;
  this.anglara.RemoveCartdata(this.removedata).subscribe(

    data=>this.handleRemoveCartResponse(data),
    error=>this.notify.error(error.error.Response.message)
    )
 

}
handleRemoveCartResponse(data){
  this.arr=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  
  this.notify.success(this.arr[0]['value'],{timeout:0});
  location.reload();
}
decrease(event){
 let id=event.target.dataset.element;
 //$(document).ready(function(){
   let tt=parseInt($("#item_"+id).text());
   console.log(tt);
   if(tt>1){
    $("#item_"+id).text(tt-1);
    //hhtp requse
    this.editBydata(tt-1,id);
   }
  

   //console.log($("#item_"+id).text());
 //});
 
 console.log(id);
}
increase(event){
  let id=event.target.dataset.element;
  let tt=parseInt($("#item_"+id).text());
  $("#item_"+id).text(tt+1);
  this.editBydata(tt+1,id);
  console.log(id);

}
editBydata(quantity,type){
  this.editdata.token=this.Token.get();
  this.editdata.type=type;
  this.editdata.user=0;
  this.editdata.quantity=quantity;
  this.anglara.editCartdata(this.editdata).subscribe(

    data=>this.handleEditCartResponse(data),
    error=>this.notify.error(error.error.Response.message)
    )
 
}
handleEditCartResponse(data){
  this.arr=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  
  this.notify.success(this.arr[0]['value'],{timeout:0});
}
moreshopping(){
  this.route.navigateByUrl('/');
}
checkout(){
  this.route.navigateByUrl('/checkout');
}
// errorResponce(error){
// console.log(error.error.Response.message);
// }
}
