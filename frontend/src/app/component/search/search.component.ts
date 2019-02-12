import { AnglaraService } from './../../sevices/anglara.service';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormGroup, FormArray, FormControl } from '@angular/forms';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {
  
  public mydata:any;
  public temp:any;
  public path:any;
  public root:any;
  public brand:any;
  public key:any;
  public variant:any;
  public imgBaseUrl="http://localhost:8000/Uploads/Product_images/";
  public form={
    search:null
  };
  // public formy={
    
  //   discount:

  // };
  filter_form=new FormGroup({
    brand:new FormArray([]),
    variant:new FormArray([]),
    discount:new FormArray([]),
    cat_id:new FormControl,
    min:new FormControl,
    max:new FormControl

  });
  constructor(private anglara:AnglaraService,
    private router:ActivatedRoute,
    private route:Router,) { 
    
  }
  
  getproduct(data){
  
    this.anglara.getproduct(data).subscribe(
  
     
      data=>this.handleResponse(data)
    )
  }
  
  

  
  ngOnInit() {
  
    this.router.paramMap.subscribe(
      params=>{
      let item=params.get('search');
    console.log(item);
    this.form.search=item;
    this.getproduct(this.form);
      });
    
  }
  
  handleResponse(data){
   //console.log(data);
this.mydata=data.data;
this.path=data.path;
this.brand=data.brand.names;
this.variant=data.variant;

this.variant = Object.keys(this.variant[0]).map(key => ({type: key, value: this.variant[0][key]}));

for (const {type, index} of this.variant.map((type, index) => ({ type, index }))) {
  //console.log(type); // 9, 2, 5
  let temp=this.variant[index]['value'];
  if(temp!=null)
  temp=Object.keys(temp).map(key => ({type: key, value: temp[key]}));
  //console.log(this.this.variant[index]['value']);
  this.variant[index]['value']=temp;
  //this.dam= Object.keys(this.this.variant).map(key => ({type: key, value: this.dam[key]}));
  //console.log(this.temp);
  ///console.log(index); // 0, 1, 2
}
this.root=Object.keys(this.path.root).map(key=>({type:key,value:this.path.root[key]}));
//console.log(this.variant);
this.key=this.root[this.root.length-1]['type'];
console.log(this.root);
console.log(this.root[0]['type']);
console.log(this.root[this.root.length-1]['type']);
console.log(data);
console.log(this.variant);
// //this.temp = Object.keys(data.data).map(key => ({type: key, value: data.data[key]}));
//     this.mappedy = Object.keys(data.data).map(key => ({type: key, value: data.data[key]}));
//     //this.temp = Object.keys(this.mappedy).map(key => ({type: key, value: this.mappedy[key]}));
//     console.log(this.mappedy.length);
//     // for(let d of this.mappedy){
//     //  console.log(d);
//     // }
//     // //console.log(this.mydata[0]['name']);
//     // for (const {type, index} of this.mappedy.map((type, index) => ({ type, index }))) {
//     //   //console.log(type); // 9, 2, 5
//     //   let temp=this.mappedy[index]['value'];
//     //   if(temp!=null)
//     //   temp=Object.keys(temp).map(key => ({type: key, value: temp[key]}));
//     //   //console.log(this.mappedy[index]['value']);
//     //   this.mappedy[index]['value']=temp;
//     //   //this.dam= Object.keys(this.cat_map).map(key => ({type: key, value: this.dam[key]}));
//     //   //console.log(this.temp);
//     //   ///console.log(index); // 0, 1, 2
//     // }
////    console.log(this.mappedy);
  }
  increase(data){
    //console.log(data);
    this.anglara.getAscendingOrderProduct(data).subscribe(
  
     
      data=>this.handleResponse(data)
    )
  }
  decrease(data){
   // console.log(data);
    this.anglara.getDescendingOrderProduct(data).subscribe(
  
     
      data=>this.handleResponse(data)
    )
  }
  newest(data){
    //console.log(data);
    this.anglara.getLatestProduct(data).subscribe(
  
     
      data=>this.handleResponse(data)
    )
  }
  getItemBycategory(data){
    this.anglara.getProductByCategory(data).subscribe(
  
     
      data=>this.handleResponse(data)
    )
  }
  
  filter(){
    var formData = new FormData(document.querySelector('form'))
    // var form = document.querySelector('#filterform');
    //  var data = new FormData(form[1]);
     //var queryString = $('#myFormId').formSerialize();
     // var queryString = $('#filterform').serialize();
  //   console.log("hii");
  // console.log(form);
  }
}
