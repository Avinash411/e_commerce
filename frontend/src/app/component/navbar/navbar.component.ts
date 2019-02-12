import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';
import { HttpClientJsonpModule } from '@angular/common/http';
import { AnglaraService } from './../../sevices/anglara.service';
import { TokenService } from './../../sevices/token.service';

import { AuthService } from './../../sevices/auth.service';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { SearchComponent } from '../search/search.component';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css'],
  // template: `
  // <app-child [childMessage]="parentMessage"></app-child>`
})

export class NavbarComponent implements OnInit {
public loggedIn:boolean;
public data:any[];
public categories:any;
public base:any;
public cat:any;
public dam:any;
public mapped:any;
public cat_map:any;

//parentMessage = "message from parent";
public form={
  search:null
};

constructor(
    private Auth:AuthService,
    private router:Router,
    private Token:TokenService,
    private anglara:AnglaraService,
    private http:HttpClientJsonpModule,
    private s:SearchComponent
   ) { }
cd=[
  {name:'1'},
  {name:'2'}
];
  ngOnInit() {
    this.Auth.authStatus.subscribe(value=>this.loggedIn=value);
    this.anglara.getallcategory().subscribe(
      //response=>
       data=>
       this.handleResponse(data),
      //console.log(this.categories);
      //error=>console.log(error)
      );
  }
  handleResponse(data){
    this.categories =data.data;
  this.base=this.categories.parent;
  this.cat=this.categories.data;
  

this.mapped = Object.keys(this.base).map(key => ({type: key, value: this.base[key]}));
this.cat_map= Object.keys(this.cat).map(key => ({type: key, value: this.cat[key]}));
//console.log(this.cat_map);
for (const {type, index} of this.cat_map.map((type, index) => ({ type, index }))) {
  //console.log(type); // 9, 2, 5
  let temp=this.cat_map[index]['value'];
  if(temp!=null)
  temp=Object.keys(temp).map(key => ({type: key, value: temp[key]}));
  //console.log(this.cat_map[index]['value']);
  this.cat_map[index]['value']=temp;
  //this.dam= Object.keys(this.cat_map).map(key => ({type: key, value: this.dam[key]}));
  //console.log(this.temp);
  ///console.log(index); // 0, 1, 2
}
//console.log(this.cat_map);
// for(let i of this.cat_map){

//  // console.log(indexOf(i));
 
//     if(i['value']!=null){
//     this.cat_map[i]['value'] =  Object.keys(i['value']).map(key => ({type: key, value: i['value'][key]}));
//     break;  
//   }
 
// }
//console.log(this.mapped);
    console.log(this.cat_map);
    
  }
  logout(event:MouseEvent){
    event.preventDefault();
    this.Token.remove();
    this.Auth.chageAuthStatus(false);
    this.router.navigateByUrl('/login');
  }
  onSubmit(){
     console.log(this.form);
   // console.log(temp);
   this.router.navigateByUrl('/search/'+this.form.search);
    //this.s.getproduct(this.form);
   // 
  }

}









// 
// {{--<ul>
//   <li
//   *ngFor="let c of cor"
//   >{{c.name}}</li>
  

// <li>{{ mapped?.length }}</li>

//   </ul>

//   <div
//   *ngFor="let m of mapped;index as i"
//   >data:{{m['value']}}
// <p>ind::{{i}}</p>
// </div>

// <hr>
// <div
//   *ngFor="let m of cat_map;index as i"
//   >parent:{{m['type']}}
//   <hr>
//   <div
//   *ngFor="let n of m['value']"
//       >value:{{n['value']}}</div>
// <hr>
// </div>

// --}}