<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Variants extends Model
{
	use SoftDeletes;
    protected $fillable=['variant_name','category_id'];
   protected $dates = ['deleted_at'];
   public function value(){
   	return $this->hasMany('App\Variant_Value','variant_id','id');
   }
   
   public function category(){
    	return $this->hasOne('App\ProductCategory','id','category_id');
    }
}
