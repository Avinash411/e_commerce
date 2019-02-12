import { AnglaraService } from './../../../sevices/anglara.service';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { SnotifyService } from 'ng-snotify';

@Component({
  selector: 'app-response-reset',
  templateUrl: './response-reset.component.html',
  styleUrls: ['./response-reset.component.css']
})
export class ResponseResetComponent implements OnInit {
  public error=[];
  public form={
    email:null,
    password:null,
    password_confirmation:null,
    resetToken:null
  }
  constructor(
    private route:ActivatedRoute,
    private angalra:AnglaraService,
    private router:Router,
    private notify:SnotifyService
  ) { 
    
    route.queryParams.subscribe(params=>{
      this.form.resetToken=params['token']
    });
  }

  ngOnInit() {
  }
  onSubmit(){
  this.angalra.changePassword(this.form).subscribe(
    data=>this.handleResponse(data),
    error=>this.handleError(error)
  )
  }
  handleResponse(data){
    let _router=this.router;
    this.notify.confirm('Password Changed ! Now login with new Password',{
      buttons:[
        {
          text:'Okey',
        action:toster=>{
           _router.navigateByUrl('/login'),
        this.notify.remove(toster.id)
      }
      },
      ]
    })
   
  }
  handleError(error){
    this.error=error.error.errors;
  }
}
