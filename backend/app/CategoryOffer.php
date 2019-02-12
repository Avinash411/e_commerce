<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ProductCategory;
class CategoryOffer extends Model
{

	use SoftDeletes;
    protected $fillable=['category_id','type','offer_amount','validity_From','validity_To'];
    protected $dates = ['validity_From', 'validity_To','deleted_at'];
 // protected $dates = ['deleted_at'];
    public function category(){
    	return $this->hasOne('App\ProductCategory','id','category_id');
    }
}
	
