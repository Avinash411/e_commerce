<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product_details extends Model
{
    use SoftDeletes;

   protected $fillable=['product_variant_id','value_id'];
    protected $dates = ['deleted_at'];
    public function value(){
		return $this->hasOne('App\Variant_Value','id','value_id');
	}
}
