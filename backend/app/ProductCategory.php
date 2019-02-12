<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{

    use SoftDeletes;
	
    // mash data entering into product_categories table
    protected $fillable=['category_name','parent_category'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //softdelete like entening deleted date
    protected $dates = ['deleted_at'];

}
