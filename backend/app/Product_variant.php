<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product_variant extends Model
{
	use SoftDeletes;

   protected $fillable=['product_id','combination','stock_keeping_unit','price','image'];
    protected $dates = ['deleted_at'];


    public function getCurrentStock()
    {
    	 return $this->hasMany('\App\QuantityOfProduct','product_variant_id','id')->latest();
    }
}
