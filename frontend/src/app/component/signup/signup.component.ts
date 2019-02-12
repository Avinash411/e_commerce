import { TokenService } from './../../sevices/token.service';
import { AnglaraService } from './../../sevices/anglara.service';

import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {
  public form={
    email:null,
    fname:null,
    lname:null,
    password:null,
    phone:null,
    gender:null,
    password_confirmation:null
  };
  public error=[];
  constructor(
    private service:AnglaraService,
    private token:TokenService,
    private router:Router
    ) { }

  ngOnInit() {
  }
  onSubmit(){
  this.service.singup(this.form).subscribe(
 data=>this.handleResponse(data),
 error=>this.handleError(error)
  );
  }
  handleResponse(data){
    this.token.handle(data.access_token);
     this.router.navigateByUrl('/profile');
 }
  handleError(error){
    this.error=error.error.errors;
   }

}
