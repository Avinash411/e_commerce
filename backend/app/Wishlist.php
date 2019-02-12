<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Wishlist extends Model
{
     use SoftDeletes;
    protected $fillable=['user_id','product_id','product_variant_id','deleted_at'];
}
