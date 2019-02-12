import { CheckoutComponent } from './component/checkout/checkout.component';
import { WishlistComponent } from './component/wishlist/wishlist.component';
import { CartComponent } from './component/cart/cart.component';
import { ProductDetailsComponent } from './component/product-details/product-details.component';
import { ProductComponent } from './component/product/product.component';
import { SearchComponent } from './component/search/search.component';

import { AfterloginService } from './sevices/afterlogin.service';
import { BeforeloginService } from './sevices/beforelogin.service';
import { ProfileComponent } from './component/profile/profile.component';
import { LoginComponent } from './component/login/login.component';
import { NgModule, Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { SignupComponent } from './component/signup/signup.component';
import { RequestResetComponent } from './component/password/request-reset/request-reset.component';
import { ResponseResetComponent } from './component/password/response-reset/response-reset.component';

const appRoutes:Routes=[
  {
    path:'login',
    component:LoginComponent,
    canActivate:[BeforeloginService]
  },
  
  {
    path:'signup',
    component:SignupComponent,
    canActivate:[BeforeloginService]

  },
  {
    path:'profile',
    component:ProfileComponent,
    canActivate:[AfterloginService]
  },
  {
    path:'request-password-reset',
    component:RequestResetComponent,
    canActivate:[BeforeloginService]
  },
  {
    path:'response-password-reset',
    component:ResponseResetComponent,
    canActivate:[BeforeloginService]
  },
  {
    path:'search/:search',
    component:SearchComponent,
    
  },
  {
    path:'product/:search',
    component:ProductDetailsComponent,
    
  },
  {
    path:'cart',
    component:CartComponent,
    canActivate:[AfterloginService]
  },
  {
    path:'wishlist',
    component:WishlistComponent,
    canActivate:[AfterloginService]
  },
  {
    path:'checkout',
    component:CheckoutComponent,
    canActivate:[AfterloginService]
  },
  
]
@NgModule({
  declarations: [],
  imports: [
    
    RouterModule.forRoot (appRoutes)
    
  ],
  exports:[
    RouterModule
  ]
})
export class AppRoutingModule { }
