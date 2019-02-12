<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Address extends Model
{
	 
 use SoftDeletes;
     protected $fillable=['user_id','name','mobile_no','pincode','address_description','locality','city_id','state_id','country_id','address_type','deleted_at'];
}
