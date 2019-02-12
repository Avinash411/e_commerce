import { SnotifyService } from 'ng-snotify';
import { TokenService } from 'src/app/sevices/token.service';
import { AnglaraService } from './../../sevices/anglara.service';
import { Component, OnInit } from '@angular/core';
import { filter } from 'rxjs/operators';
import { empty } from 'rxjs';
import * as $ from 'jquery';
@Component({
 selector: 'app-checkout',
 templateUrl: './checkout.component.html',
 styleUrls: ['./checkout.component.css']
})
export class CheckoutComponent implements OnInit {
 public arr:any;
 public add:any;
 public arr1:any;
 public arr2:any;
 public state:any;
public showdata:any;
 public city:any;
public form={

name:null,
mob_no:null,
pin:null,
description:null,
locality:null,
city:null,
state:null,
country:null,
type:null,
token:null
};
public getcountry={

 token:null
 };
 public show={
   user:null,
   token:null
   };
 public getstates={

   token:null,
   country:null
   };
   public getcities={

     token:null,
     state:null
     };
 public country:any;
public error=[];
 constructor(
   private anglara:AnglaraService,
 private token:TokenService,
 private notify:SnotifyService
 ) { }

 ngOnInit() {
   //console.log("hii");
   this.getcountry.token=this.token.get();
   //this.anglara.getcountry(this.getcountry).
   this.anglara.getcountry(this.getcountry).subscribe(
     //data=>console.log(data.data)
         data=>this.handleCountryResponse(data),
          error=>this.notify.error(error.error.Response.message)
         )
 }
 handleCountryResponse(data){
   //console.log(data.data);
   this.country=Object.keys(data.data).map(key=>({type:key,value:data.data[key]}));
//console.log(this.country[0]['value'][0]['name']);
let myarr=[];
console.log('st');
// console.log(myarr);
console.log(this.country);
for(let j=0;j<this.country[0]['value'].length;j++){
 console.log('in');
 myarr[j] = [];
   myarr[j]['id']=this.country[0]['value']
   [j]['id'];
  
   myarr[j]['name'] = this.country[0]['value']
   [j]['name'];

}
// console.log(ty);
// var filtered = myarr.filter(function (el) {
//   return el != null;
// });
console.log("myarr");
this.arr=myarr;
console.log(this.arr);
   // for (const {type, index} of this.country.map((type, index) => ({ type, index }))) {
   //   let tempy=this.country[index]['value'];
   //   if(tempy!=null)
   //   tempy=Object.keys(tempy).map(key => ({type: key, value: tempy[key]}));
   //   temp[index]['value']=tempy;
   //   }
   //   this.types[index]['value']=temp;
   //   // let tempy=this.types[index]['value'];
   //   // if(tempy!=null)
   //   // tempy=Object.keys(tempy).map(key => ({type: key, value: tempy[key]}));
    //   // //console.log(this.this.types[index]['value']);
   //   // this.types[index]['value']=tempy;
   //   // //this.dam= Object.keys(this.this.types).map(key => ({type: key, value: this.dam[key]}));
   //   //console.log(this.temp);
   //   ///console.log(index); // 0, 1, 2
   // }

 }
 onSubmit(){
   console.log("hii");
   this.form.token=this.token.get();
   this.anglara.storeaddressdeatails(this.form).subscribe(
     //data=>console.log(data.data)
         data=>this.handleCreateAddressResponse(data),
          error=>this.notify.error(error.error.Response.message)
         )
 }
 handleCreateAddressResponse(data){
   //console.log(data);
   this.add=Object.keys(data.Response).map(key=>({type:key,value:data.Response[key]}));
  this.notify.success(this.add[0]['value'],{timeout:0});

 }
 getstate(){
//console.log("data");

let changes;
 
  changes=$('#inputcountry').val();
//console.log($('#inputcountry:selected').val());


this.getstates.country=changes;
this.getstates.token=this.token.get();
//console.log(this.getstates);
this.anglara.getstatedeatails(this.getstates).subscribe(
 //data=>console.log(data.data)
     data=>this.handlestateResponse(data),
      error=>this.notify.error(error.error.Response.message)
     )

 }
 handlestateResponse(data){
console.log(data);
this.state=Object.keys(data.data).map(key=>({type:key,value:data.data[key]}));
//console.log(this.country[0]['value'][0]['name']);
let myarr=[];
console.log('st');
// console.log(myarr);
console.log(this.state);
for(let j=0;j<this.state[0]['value'].length;j++){
 console.log('in');
 myarr[j] = [];
   myarr[j]['id']=this.state[0]['value']
   [j]['id'];
  
   myarr[j]['name'] = this.state[0]['value']
   [j]['name'];

}
// console.log(ty);
// var filtered = myarr.filter(function (el) {
//   return el != null;
// });
console.log("myarr");
this.arr1=myarr;
console.log(this.arr1);
 }
 ////city
 getcity(){
   //console.log("data");
 
   let changes;
  
    
     changes=$('#inputstate').val();
   console.log(changes);
   
 
 
  this.getcities.state=changes;
  this.getcities.token=this.token.get();
  //console.log(this.getcities);
  this.anglara.getcitydeatails(this.getcities).subscribe(
    //data=>console.log(data.data)
        data=>this.handlecityResponse(data),
         error=>this.notify.error(error.error.Response.message)
        )
 
    }
    handlecityResponse(data){
  console.log(data);
  this.city=Object.keys(data.data).map(key=>({type:key,value:data.data[key]}));
  //console.log(this.country[0]['value'][0]['name']);
  let myarr=[];
  //console.log('st');
  // console.log(myarr);
  //console.log(this.state);
  for(let j=0;j<this.city[0]['value'].length;j++){
    console.log('in');
    myarr[j] = [];
      myarr[j]['id']=this.city[0]['value']
      [j]['id'];
     
      myarr[j]['name'] = this.city[0]['value']
      [j]['name'];
 
  }
   // console.log(ty);
  
  
  // var filtered = myarr.filter(function (el) {
  //   return el != null;
  // });
   console.log("myarr");
   this.arr2=myarr;
   console.log(this.arr2);
    }
getallexistingAddress(){
// console.log("kii");
 this.show.user=0;
 this.show.token=this.token.get();
 this.anglara.getshowAddressdeatails(this.show).subscribe(
   //data=>console.log(data.data)
       data=>this.handleshowAddressResponse(data),
        error=>this.notify.error(error.error.Response.message)
       )

}
handleshowAddressResponse(data){
 //console.log("hii show");
 console.log(data.data);

 this.showdata=data.data;
}
order()
{
  console.log("hiii dfsdsdfsd");
let address=$("input[type='radio']:checked").val();
//  let address=$("input[type='radio']").val();
//console.log(address);
}

}



