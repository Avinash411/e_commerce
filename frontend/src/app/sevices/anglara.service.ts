import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map } from 'rxjs/operators';

@Injectable({
 providedIn: 'root'
})
export class AnglaraService {
private baseurl='http://localhost:8000/api';

// if(let val = (localStorage.getItem('token')))
// private token = localStorage.getItem('token');

 constructor(private http:HttpClient) { }
 singup(data){
   return this.http.post(`${this.baseurl}/signup`,data)
 }
 login(data){
  
   return this.http.post(`${this.baseurl}/login`,data)
 }
 sendPasswordResetLink(data){
   return this.http.post(`${this.baseurl}/sendPasswordResetLink`,data)
 }
 changePassword(data){
   console.log(data);
   return this.http.post(`${this.baseurl}/resetPassword`,data)
 }
 loginUserDetails(){
   return this.http.get(`${this.baseurl}/profile/`+localStorage.getItem('token'))
  
 }
 getallcategory(){
   return this.http.get(`${this.baseurl}/allcategory`,{responseType:"json"})
 }
 updateProfile(data){
   //console.log(data);
   return this.http.post(`${this.baseurl}/updateprofile`,data)
 }
 delete(data){
   return this.http.post(`${this.baseurl}/delete`,data)
 }
 getproduct(data){
 //this.http.post(`${this.baseurl}/search_product_name`,data).subscribe(data=>console.log(data));
   return this.http.post(`${this.baseurl}/search_product_name`,data)
 }
 getAscendingOrderProduct(data){
   return this.http.get(`${this.baseurl}/price_asc/`+data+localStorage.getItem('token'))
 
 }
 getDescendingOrderProduct(data){
   return this.http.get(`${this.baseurl}/price_des/`+data+localStorage.getItem('token'))
 }
 getLatestProduct(data){
   return this.http.get(`${this.baseurl}/newest/`+data+localStorage.getItem('token'))
 }
 getProductByCategory(data){
   return this.http.get(`${this.baseurl}/path_data/`+data+localStorage.getItem('token'))
 }
 getProductdetails(data){
   return this.http.get(`${this.baseurl}/product/`+data+localStorage.getItem('token'))
 }
 storeInCart(data){
   //console.log("backkk");
  //console.log(data);
    return this.http.post(`${this.baseurl}/cart`,data)
 }
 showAllCartdata(data){
   return this.http.post(`${this.baseurl}/CartDataOfUser`,data)
  // return this.http.post(`${this.baseurl}/CartDataOfUser/`+localStorage.getItem('token'))
 }
 RemoveCartdata(data){
   return this.http.post(`${this.baseurl}/CartRemove`,data)
 }
 editCartdata(data){
   return this.http.post(`${this.baseurl}/CartDataEdit`,data)
 }
 storeInWishlist(data){
   //console.log("backkk");
  //console.log(data);
    return this.http.post(`${this.baseurl}/createwishlist`,data)
 }
 showAllWishlistdata(data){
 
 

   return this.http.post(`${this.baseurl}/WishlistDataOfUser`,data)
  // return this.http.post(`${this.baseurl}/CartDataOfUser/`+localStorage.getItem('token'))
 }
 RemoveWishlistdata(data){
   return this.http.post(`${this.baseurl}/WishlistRemove`,data)
 }
 WishlistdataAddtoCart(data){
   return this.http.post(`${this.baseurl}/WishlistAddToCart`,data)
 }
 getcountry(data){
   return this.http.post(`${this.baseurl}/getcountry`,data)
 }
 getstatedeatails(data){
   return this.http.post(`${this.baseurl}/getstate`,data)
 }
 getcitydeatails(data){
   return this.http.post(`${this.baseurl}/getcity`,data)
 }
 storeaddressdeatails(data){
   //console.log(data);
   return this.http.post(`${this.baseurl}/AddingAddress`,data)
 }
 getshowAddressdeatails(data){
   return this.http.post(`${this.baseurl}/getAllAddress`,data)
 }
}


