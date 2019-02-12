import { AuthService } from './../../sevices/auth.service';
import { TokenService } from './../../sevices/token.service';
import { AnglaraService } from './../../sevices/anglara.service';
import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  
private url='http://localhost:8000';
  public form={
    email:null,
    password:null
  };
  constructor(
    private service:AnglaraService,
    private token:TokenService,
    private router:Router,
    private Auth:AuthService 
    ) { 
     
    }
public error=null;
  ngOnInit() {

 //CSRF_TOKEN = '{{ csrf_token() }}';

  }
  onSubmit(){
    
this.service.login(this.form).subscribe(
 data=>this.handleResponse(data),
 error=>this.handleError(error)
);

  }
  handleResponse(data){
    console.log(data);
    //console.log(this.token.loggedIn());
    //console.log(this.token.payload(localStorage.getItem('token')));
    this.token.handle(data.access_token);
    this.Auth.chageAuthStatus(true);
     this.router.navigateByUrl('profile');
 }
  handleError(error){
   this.error=error.error.error;
  }
}
