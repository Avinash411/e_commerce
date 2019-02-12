<?php

namespace App;
use App\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Brand extends Model
{

	use SoftDeletes;
    protected $fillable=['brand_name','brand_description','category_id'];
   
    public function product_category(){
    	return $this->hasMany(ProductCategory::class);
    }
    public function category(){
    	return $this->hasOne('App\ProductCategory','id','category_id');
    }
    protected $date=['deleted_at'];
}
