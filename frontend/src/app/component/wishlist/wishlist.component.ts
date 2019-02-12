import { element } from 'protractor';
import { ActivatedRoute, Router } from '@angular/router';
import { AnglaraService } from './../../sevices/anglara.service';
import { Component, OnInit } from '@angular/core';
import { SnotifyService } from 'ng-snotify';
import { TokenService } from 'src/app/sevices/token.service';

@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  styleUrls: ['./wishlist.component.css']
})
export class WishlistComponent implements OnInit {
  public arr:any;
  public card:any;
  public VariantimgBaseUrl="http://localhost:8000/Uploads/Variants_image/";
 
  public showall={
    
    token:null
   
  };
  public removedata={
    type:null,
    token:null,
    user:null
   
  };
  public addtocartdata={
    type:null,
    token:null,
    user:null
   
  };
  constructor(
    private router:ActivatedRoute,
    private anglara:AnglaraService,
    private Token:TokenService,
    private notify:SnotifyService,
    private route:Router,
  ) { }

  ngOnInit() {
    // this.router.paramMap.subscribe(
    //   params=>{
    //   let item=params.get('item');
    //   //console.log("cart");
    // //console.log(item);
    // //let zero=false;
    // let user=0;
    
    // if(item!='0'){
    //   this.store_in_wishlist(item,user);
    // } else{
      this.show_wishlist_details();
 // }
    
    //this.form.search=item;

    //this.store_in_cart(item);
      //});
  }
  store_in_wishlist(item,user){
//     this.form1.type=item;
//     this.form1.user=user;
//     //this.form1.quantity=1;
   
//     this.form1.token=this.Token.get();
// this.anglara.storeInWishlist(this.form1).subscribe(

// //data=>console.log(data)
// //data=>this.handleCartResponse(data)
// data=>this.handleCartResponse(data),
// error=>this.notify.error(error.error.error)
// )

 }
// handleCartResponse(data){
  
//   this.arr=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  
//   this.notify.success(this.arr[0]['value'],{timeout:0});
// }
show_wishlist_details(){
  this.showall.token=this.Token.get();
  this.anglara.showAllWishlistdata(this.showall).subscribe(

    //data=>console.log(data)
    //data=>this.handleCartResponse(data)
    data=>this.handleAllDataOfWishlistResponse(data),
    error=>this.notify.error(error.error.Response.message)
    )
}
handleAllDataOfWishlistResponse(data){
console.log("wish");
  console.log(data)
this.card=data.data[0];
//this.card=Object.keys(data.data[0]).map(key=>({type:key,value:data.data[0]['key']}));
console.log(this.card);

}
remove(event){
  console.log("wish list Remove");
  //console.log(event.target.dataset.element);
  this.removedata.token=this.Token.get();
  this.removedata.type=event.target.dataset.element;
  this.removedata.user=0;
  this.anglara.RemoveWishlistdata(this.removedata).subscribe(
//data=>console.log(data)
   data=>this.handleRemoveWishlistResponse(data),
    error=>this.notify.error(error.error.Response.message)
    )
 

}
handleRemoveWishlistResponse(data){
  this.arr=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  
  this.notify.success(this.arr[0]['value'],{timeout:0});
  //this.route.navigateByUrl('wishlist');
  location.reload();
}
addtocard(event){
  let id=event.target.dataset.element;
  //console.log(id);
  this.addtocartdata.token=this.Token.get();
  this.addtocartdata.type=event.target.dataset.element;
  this.addtocartdata.user=0;
  this.anglara.WishlistdataAddtoCart(this.addtocartdata).subscribe(
//data=>console.log(data)
   data=>this.handleAddToCartResponse(data),
    error=>this.notify.error(error.error.Response.message)
    )
}
handleAddToCartResponse(data){
  this.arr=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  
  this.notify.success(this.arr[0]['value'],{timeout:0});
  location.reload();
}
}
