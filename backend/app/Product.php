<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Brand;
use App\ProductCategory;
use App\Variants;
use App\QuantityOfProduct;
class Product extends Model
{
    use SoftDeletes;

    protected $fillable=['product_name','product_description','image','category_id','brand_id','min_price','max_price'];
    protected $dates = ['deleted_at'];

    public function brand(){
    	return $this->hasOne('App\Brand','id','brand_id');
    }
    public function category(){
    	return $this->hasOne('App\ProductCategory','id','category_id');
    }
    public function one_product_variant(){
    	return $this->hasMany('\App\Product_variant','product_id','id');
    }


    public function getProductVariant(){
    	return $this->hasMany('\App\Product_variant','product_id','id');
    }

    public function getQuantityOfProduct(){
        return $this->hasMany('\App\QuantityOfProduct','product_id','id');
    }

    public function getProductVariantTemp(){
        return $this->hasMany('\App\Product_variant','product_id','id');
    }
    public function getVariant(){
        return $this->hasMany('\App\Variants','id','variant_id');
    }
    
// public function value(){
//     return $this->hasMany('App\Variant_Value','variant_id','id');
//    }



}
