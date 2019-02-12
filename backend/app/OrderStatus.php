<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
   protected $fillable=['reference_Order_id','order_id','status','process_by'];
}
