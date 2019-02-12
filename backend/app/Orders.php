<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

	 

          
    protected $fillable=['user_id','product_id','ordered_combination','quantity','order_id','unitprice','address_id','approve_status','discount_percentage'];
}
