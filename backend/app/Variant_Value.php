<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Variant_Value extends Model
{
	use SoftDeletes;
	protected $fillable=['variant_id','variant_value'];
	public function variants(){
		return $this->hasOne('App\Variants','id','variant_id');
		
	}
	 // public function category(){
  //   	return $this->hasOne('App\ProductCategory','id','category_id');
  //   }
    protected $date=['deleted_at'];
}
