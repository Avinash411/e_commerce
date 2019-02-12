<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\User;
use DB;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
class ResetPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
       
        
        if(!$this->ValidateEmail($request->email)){
        
            return $this->failedResponse();
        }
        $this->send($request->email);

        return $this->SuccessResponse();
    }
    
    public function send($email)
    {
        $token=$this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token));
    }
    public function createToken($email)
    {

        $oldToken=DB::table('password_resets')->where('email',$email)->first();
        if($oldToken){
            return $oldToken;
        }
       $token=str_random(60);
       $this->saveToken($token,$email);
       return $token;
    }
    public function saveToken($token,$email)
    {
       DB::table('password_resets')->insert([
           'email'=>$email,
           'token'=>$token,
           'created_at'=>Carbon::now(),

       ]);
    }
    public function ValidateEmail($email)
    {
        
       $user=User::where('email',$email)->first();
       if(empty($user)){
           return false;
       }
       return true;
    }
    public function failedResponse()
    {
        
       return response()->json([
           'error'=>'Email doesn\'t found on our database'
       ],Response::HTTP_NOT_FOUND);
    }
    public function SuccessResponse()
    {
        return response()->json([
            'data'=>'Reset Link is send Successfully in your Email'
        ],Response::HTTP_OK);
    }

}
