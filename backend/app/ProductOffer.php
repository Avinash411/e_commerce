<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductOffer extends Model
{
 use SoftDeletes;
    protected $fillable=['product_id','type','offer_amount','validity_From','validity_To'];
    protected $dates = ['validity_From', 'validity_To','deleted_at'];
 // protected $dates = ['deleted_at'];
    public function product(){
    	return $this->hasOne('App\Product','id','product_id');
    }
}
