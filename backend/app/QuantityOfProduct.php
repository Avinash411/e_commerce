<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class QuantityOfProduct extends Model
{
     use SoftDeletes;
     protected $fillable=['quantity','order_id','product_id','product_variant_id','deleted_at'];
}
