import { AuthService } from './../../sevices/auth.service';
import { AnglaraService } from './../../sevices/anglara.service';
import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { SnotifyService } from 'ng-snotify';
import { TokenService } from 'src/app/sevices/token.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
 public data;
 public abc;
 public form={
  email:null,
  fname:null,
  lname:null,
 
  phone:null,
  gender:null,
  token:null
 
};

public error=[];
  constructor(
    private route:ActivatedRoute,
    private anglara:AnglaraService,
    private router:Router,
    private notify:SnotifyService,
    private Token:TokenService,
    private Auth:AuthService
    
    ) { 
      this.abc =  this.anglara.loginUserDetails().subscribe(
     
        response=>{
         
         this.abc=response;
         this.form.email=this.abc.email;
         this.form.phone=this.abc.mobile;
         this.form.fname=this.abc.fname;
         this.form.lname=this.abc.lname;
         this.form.gender=this.abc.gender;
         this.form.token=this.Token.get();
          console.log(this.abc);
        }
         
          );
         
    }
    
  ngOnInit() {
    
   
  }
  update(){
    console.log(this.form);
    this.anglara.updateProfile(this.form).subscribe(
      data=>this.handleResponse(data),
      error=>this.handleError(error)

    )
  }
  handleResponse(data){
    let _router=this.router;
    this.notify.confirm('Profile Updated',{
      buttons:[
        {
          text:'Okey',
        action:toster=>{
           _router.navigateByUrl('/profile'),
        this.notify.remove(toster.id)
      }
      },
      ]
    })
   
  }
  handleError(error){
    this.error=error.error.errors;
  }
  delete(){
   console.log("hii");
   this.anglara.delete(this.form).subscribe(
    data=>this.handleDeletedResponse(data),
    error=>this.handleError(error)

  )
  }
  handleDeletedResponse(data){
    let _router=this.router;
    this.notify.confirm('Profile deleted',{
      buttons:[
        {
          text:'Okey',
        action:toster=>{
          this.Token.remove();
          
         
           _router.navigateByUrl('login'),
        this.notify.remove(toster.id)
      }
      },
      ]
    })
   
  }
       
}
