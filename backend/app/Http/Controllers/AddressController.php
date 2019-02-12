<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\AddressValidation;
use Illuminate\Support\Facades\DB;
use App\anglara\Transformers\Subtransformer;
use Carbon\Carbon;


use App\User;

class AddressController extends ApiController
{
    

    protected $Transformer;
    function __construct(Subtransformer $Transformer){
       $this->Transformer=$Transformer;
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//here requierd like user have to login so user id as user to store addres data
    public function store(Request $request)
    {
        
       // $user=User::find($request['user']);
       $token_parts = explode('.', $request['token']);
       $token_header = $token_parts[1];
       
       //dd($token_header);
       // base64 decode to get a json string
       $token_header_json = base64_decode($token_header);
       
       // you'll get this with the provided token:
       // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
       
       // then convert the json to an array
       $token_header_array = json_decode($token_header_json, true);
       $user = User::find($token_header_array['sub']);
        if(!$user){
          return $this->respondForNotAvailable("Please login");
        }

         
        $add=Address::create([
         'user_id'=>$user->id,
         'name'=>$request['name'],
         'mobile_no'=>$request['mob_no'],
         'pincode'=>$request['pin'],
         'address_description'=>$request['description'],
         'locality'=>$request['locality'],
         'city_id'=>$request['city'],
         'state_id'=>$request['state'],
         'country_id'=>$request['country'],
         'address_type'=>$request['type']
        ]);
        if($add){
    return $this->respondForAccepted("Address added successfully");
        }
    }



    //
//here only required user Id as user    
public function getCountry(Request $request){
  
    $token_parts = explode('.', $request['token']);
      $token_header = $token_parts[1];
      
      //dd($token_header);
      // base64 decode to get a json string
      $token_header_json = base64_decode($token_header);
      
      // you'll get this with the provided token:
      // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
      
      // then convert the json to an array
      $token_header_array = json_decode($token_header_json, true);
      $user = User::find($token_header_array['sub']);
    //$user=User::where('id',$request['user'])->first();
        //   if(!$user){
        //     return $this->respondForUnauthorized("Unauthorized Request");
        //   }
    //$user=User::find($request['user']);
  if(!$user){
    return $this->respondForUnauthorized("UNAUTHORIZED Request!");

  }
  $country = DB::table('countries')->get();

    if(!count($country)){
        return $this->respondNotFound("Not Found");
    }

  return $this->Respond([
   'data'=>$this->Transformer->getAllCountry($country->toArray())
  ]);
}

//get state of particular country passing by country id as country
public function getState(Request $request){
    $state = DB::table('states')->where('country_id',$request['country'])->get();

    if(!count($state)){
        return $this->respondNotFound("Not Found");
    }

  return $this->Respond([
   'data'=>$this->Transformer->getAllState($state->toArray())
  ]);
    }

    //get cities of particular state passing by state id as state
public function getCity(Request $request){
    $cities = DB::table('cities')->where('state_id',$request['state'])->get();

    if(!count($cities)){
        return $this->respondNotFound("Not Found");
    }
  return $this->Respond([
   'data'=>$this->Transformer->getAllCity($cities->toArray())
  ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    //show all address of particular user so here required user id as user
    public function show(Request $request)
    {
      // $user=User::find($request['user']);
      //dd($request);
      $token_parts = explode('.', $request['token']);
      $token_header = $token_parts[1];
      
      //dd($token_header);
      // base64 decode to get a json string
      $token_header_json = base64_decode($token_header);
      
      // you'll get this with the provided token:
      // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
      
      // then convert the json to an array
      $token_header_array = json_decode($token_header_json, true);
      $user = User::find($token_header_array['sub']);
        if(!$user){
          return $this->respondForNotAvailable("Please login");
        }
        $address=Address::where('user_id',$user->id)->get();

        if(!count($address)){
            return $this->respondForNotImplemented("None Address available!");
        }
     $add=[];
      foreach ($address as $key => $value) {
          $add[$key]['Id']=$value['id'];
          $add[$key]['Name']=$value['name'];
          $add[$key]['Mobile_No']=$value['mobile_no'];
          $add[$key]['PinCode']=$value['pincode'];
          $add[$key]['Address_Details']=$value['address_description'];
          $add[$key]['Address_Type']=$value['address_type'];
          $add[$key]['City']=DB::table('cities')->where('id',$value['city_id'])->value('city_name');
          $add[$key]['State']=DB::table('states')->where('id',$value['state_id'])->value('state_name');
          $add[$key]['Country']=DB::table('countries')->where('id',$value['country_id'])->value('country_name');
 }
     return $this->Respond([
       'data'=>$this->Transformer->getAllAddress($add)
     ]);
   
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    //edit address here requierd user id as user and address Id as address
    public function edit(Request $request)
    {
        $token_parts = explode('.', $request['token']);
        $token_header = $token_parts[1];
        
        //dd($token_header);
        // base64 decode to get a json string
        $token_header_json = base64_decode($token_header);
        
        // you'll get this with the provided token:
        // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
        
        // then convert the json to an array
        $token_header_array = json_decode($token_header_json, true);
        $user = User::find($token_header_array['sub']);
        //$user=User::find($request['user']);
        if(!$user){
    return $this->respondForNotAvailable("Responce not available");
        }
        $address=Address::where([['id',$request['address']],['user_id',$user->id]])->first();
        if(!$address){
            return $this->respondNotFound("Respond Not Found");
        }

        $add=[];
     
          $add['Id']=$address->id;
          $add['Name']=$address->name;
          $add['Mobile_No']=$address->mobile_no;
          $add['PinCode']=$address->pincode;
          $add['Address_Details']=$address->address_description;
          $add['Address_Type']=$address->address_type;
          $add['location']['country_id']=$address->country_id;
          $add['location']['state_id']=$address->state_id;
          //$add['location']['city_id']=$address->city_id;            
          $add['City']=DB::table('cities')->where('id',$address->city_id)->value('city_name');
          $add['State']=DB::table('states')->where('id',$address->state_id)->value('state_name');
          $add['Country']=DB::table('countries')->where('id',$address->country_id)->value('country_name');
 
       return $this->Respond([
         'data'=>$this->Transformer->editAddress($add),
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */

    //updating address so here requied all data 
    public function update(AddressValidation $request)
    {
        $token_parts = explode('.', $request['token']);
        $token_header = $token_parts[1];
        
        //dd($token_header);
        // base64 decode to get a json string
        $token_header_json = base64_decode($token_header);
        
        // you'll get this with the provided token:
        // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
        
        // then convert the json to an array
        $token_header_array = json_decode($token_header_json, true);
        $user = User::find($token_header_array['sub']);
        //$user=User::find($request['user']);
        if(!$user){
    return $this->respondForNotAvailable("Responce not available");
        }
        $address=Address::where([['id',$request['address']],['user_id',$user->id]])->first();
        if(!$address){
            return $this->respondNotFound("Respond Not Found");
        }
        
         $address->user_id=$user->id;
         $address->name=$request['name'];
         $address->mobile_no=$request['mob_no'];
         $address->pincode=$request['pin'];
         $address->address_description=$request['description'];
         $address->locality=$request['locality'];
         $address->city_id=$request['city'];
         $address->state_id=$request['state'];
         $address->country_id=$request['country'];
         $address->address_type=$request['type'];
         $address->save();

         return $this->respondForOk("Address successfully updated");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    //soft delete address here requierd user id as user and address Id as address
    public function destroy(Request $request)
    {
        $token_parts = explode('.', $request['token']);
        $token_header = $token_parts[1];
        
        //dd($token_header);
        // base64 decode to get a json string
        $token_header_json = base64_decode($token_header);
        
        // you'll get this with the provided token:
        // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
        
        // then convert the json to an array
        $token_header_array = json_decode($token_header_json, true);
        $user = User::find($token_header_array['sub']);
        // $user=User::find($request['user']);
        if(!$user){
    return $this->respondForNotAvailable("Responce not available");
        }
        $address=Address::where([['id',$request['address']],['user_id',$user->id]])->first();
        if(!$address){
            return $this->respondNotFound("Respond Not Found");
        }
        $address->delete();
        return $this->respondForOk("Address deleted");
    }
}


