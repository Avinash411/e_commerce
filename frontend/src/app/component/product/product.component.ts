import { Component, OnInit,Input } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.css']
  
})
export class ProductComponent implements OnInit {

  constructor(
    private route:Router
  ) { }
  @Input()  data : any;
  @Input()  imgBaseUrl : any;
  public datas:any;
  ngOnInit() {
  }
  getproductdetails(datas){
    //console.log(this.form);
     console.log(datas);

    this.route.navigateByUrl('/product/'+datas);
     //this.s.getproduct(this.form);
    // 
   }
}
