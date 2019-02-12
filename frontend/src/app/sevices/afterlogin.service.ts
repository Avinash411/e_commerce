import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router/src/utils/preactivation';
import { ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { TokenService } from './token.service';

@Injectable({
  providedIn: 'root'
})
export class AfterloginService implements CanActivate{
  path: import("c:/xampp/htdocs/Ang+lara/frontend/node_modules/@angular/router/src/router_state").ActivatedRouteSnapshot[];
  route: import("c:/xampp/htdocs/Ang+lara/frontend/node_modules/@angular/router/src/router_state").ActivatedRouteSnapshot;
  
  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
      return this.Token.loggedIn();
  }
  constructor(private Token:TokenService) { }
}
