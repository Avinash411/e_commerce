<?php

namespace App\anglara\Transformers;


use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

/**
 * 
 */
 abstract class Transformer 
{
	
	
	 public function transformCollection($items,$percent){

	
        return array_map([$this,'transform'],$items,$percent);
    }
    public function transformCollectionfilter($items,$percent){

  
        return array_map([$this,'filter_transform'],$items,$percent);
    }
   
 
    public abstract function transform($item,$percent);
    public abstract function product_transform($item,$percent);
   public abstract function path_transform($item);
   public abstract function getallcategory_transform($item,$p);
   public abstract function brand_transform($item);		
   public abstract function varitant_transform($item);
   public abstract function offer_transform($item);
   public abstract function wishlistDataOfuser($item,$percent);
   public abstract function cartDataOfuser($item,$percent);
   public abstract function getAllState($state);
   public abstract function getAllCity($city);
   public abstract function getAllCountry($country);
   public abstract function getAllAddress($address);
   public abstract function editAddress($address);

}