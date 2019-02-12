<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\signupValidationOfForntend; 
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\updateuserprofile; 
use DB;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        auth()->setDefaultDriver('api');
        $this->middleware('auth:api', ['except' => ['login','signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email or password don\'t exist.'], 401);
        }

        return $this->respondWithToken($token);
    }
public function signup(signupValidationOfForntend $request)
{
    User::create([
        'fname' => $request['fname'],
        'lname' => $request['lname'],
        'email' => $request['email'],
        'mobile'=>$request['phone'],
        'password' => Hash::make($request['password']),
        'gender'=>$request['gender'],
    ]);
    return $this->login($request);
}
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user'=>auth()->user()->fname
        ]);
    }
    public function loginUserDetails($token)
    {
       // dd($token);
// break up the token into its three parts
$token_parts = explode('.', $token);
$token_header = $token_parts[1];

//dd($token_header);
// base64 decode to get a json string
$token_header_json = base64_decode($token_header);

// you'll get this with the provided token:
// {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}

// then convert the json to an array
$token_header_array = json_decode($token_header_json, true);
//dd($token_header_array);     
$user_token = $token_header_array['jti'];


//$user_id = DB::table('users')->where('id', $user_token['sub'])->value('user_id');
//dd($user_token);
// then retrieve the user from it's primary key
$user = User::find($token_header_array['sub']);
if (!$user) {
    return response()->json(['error' => 'User Not find'], 401);
}
return response()->json(
    
    $this->userdetails(auth()->user())
);

    }
    
    public function userdetails(User $user)
    {
       $arr=[];
       $arr['fname']=$user->fname;
       $arr['lname']=$user->lname;
       $arr['gender']=$user->gender;
       $arr['mobile']=$user->mobile;
       $arr['email']=$user->email;
       return $arr; 
    }
   
public function updateUserProfile(updateuserprofile $request)
{
    return $this->updateUser($request);
}
// private function getUserTableRow($request)
// {
//    return DB::table('users')->where([
//        'email'=>$request->email,
//        'token'=>$request->resetToken]);
// }
private function tokenNotFoundResponse()
{
    return response()->json([
        'error'=>'Token or User deatils is incorrect'
    ],Response::HTTP_UNPROCESSABLE_ENTITY);
   
}
private function updateUser($request)
{
    $user=User::find(\Auth::user()->id);

    if(!$user)
    {
        return response()->json([
            'error'=>'Token or User deatils is incorrect'
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $user->update([
        'fname'=>$request->fname,
        'lname'=>$request->lname,
        'email'=>$request->email,
        'mobile'=>$request->phone,
        'gender'=>$request->gender
        ]);
    
    return response()->json([
        'data'=>'Your Profile Successfully Updated'
    ],Response::HTTP_CREATED);
}
public function deleteUserProfile(Request $request)
{
    $user=User::find(\Auth::user()->id);
    if(!$user)
    {
        return response()->json([
            'error'=>'detele Proflie error.'
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $user->delete();
    return response()->json([
        'data'=>'Your Profile Successfully Deleted'
    ],Response::HTTP_OK);
}
} 