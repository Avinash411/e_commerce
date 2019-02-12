<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ChangePasswordRequest;
class ChangePasswordController extends Controller
{
    public function process(ChangePasswordRequest $request)
    {
        return $this->getPasswordResetTableRow($request)->count()>0?$this->changePassword($request):$this->tokenNotFoundResponse();
    }
    private function getPasswordResetTableRow($request)
    {
       return DB::table('password_resets')->where([
           'email'=>$request->email,
           'token'=>$request->resetToken]);
    }
    private function tokenNotFoundResponse()
    {
        return response()->json([
            'error'=>'Token or email is incorrect'
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
       
    }
    private function changePassword($request)
    {
        $user=User::where('email',$request->email)->first();
        $user->update(['password'=>\Hash::make($request->password)]);
        $this->getPasswordResetTableRow($request)->delete();
        return response()->json([
            'data'=>'Password Successfully Changed'
        ],Response::HTTP_CREATED);
    }
}
