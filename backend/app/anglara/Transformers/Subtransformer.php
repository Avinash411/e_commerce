<?php
namespace App\anglara\Transformers;
/**
 * 
 */
class Subtransformer extends Transformer
{
	
	 public function transform($product,$percent){
    
    $temp = $this->getRatesBlock($product,$percent);
   
//HERE PROBLEM WHEN NOT DISCOUNT FILTER PART 
 
       return[
        'id'=>$product['id'],  
       'name'=>$product['product_name'],
       'details'=>$product['product_description'],
       'photo'=>unserialize($product['image']),
       'rates' => $temp,
       'minimum_rate'=>$product['min_price'],
        'maximum_rate'=>$product['max_price'] ,
        
       ];
 
      
    }

    public function getallcategory_transform($arr,$p)
    {

      return[
        'parent'=>$p,
        'data'=>$arr
      ];
      //return $arr;
     // dd($arr);
    }
    public function filter_transform($product,$percent){
 
 
       $temp = $this->getRatesBlock($product,$percent);
 
   
 
//HERE PROBLEM WHEN NOT DISCOUNT FILTER PART 
 if($temp['discount_in_percentage']){
       return[
       'name'=>$product['product_name'],
       'details'=>$product['product_description'],
       'photo'=>$product['image'],
       'rates' => $temp,
       'minimum_rate'=>$product['min_price'],
        'maximum_rate'=>$product['max_price'] ,
        
       ];
       }else{
        return[
       'name'=>$product['product_name'],
       'details'=>$product['product_description'],
       'photo'=>$product['image'],
       'rates' => $temp,
       'minimum_rate'=>$product['min_price'],
        'maximum_rate'=>$product['max_price'] ,
        
       ];
       }
      
    }

    public function getAllAddress($address){
   
   return[
        // 'name'=>$address['name'],
        // 'mobile_No'=>$address['mobile_No'],
        // 'pincode'=>$address['pincode'],
        // 'address'=>$address['address_description'],
        // 'city'=>$address['city_id'],
        // 'state'=>$address['state_id'],
        // 'country'=>$address['country_id'],
        // 'address_type'=>$address['address_type']
    $address
   ];




    }
    public function editAddress($address){
      return[
        // 'name'=>$address['name'],
        // 'mobile_No'=>$address['mobile_No'],
        // 'pincode'=>$address['pincode'],
        // 'address'=>$address['address_description'],
        // 'city'=>$address['city_id'],
        // 'state'=>$address['state_id'],
        // 'country'=>$address['country_id'],
        // 'address_type'=>$address['address_type']
$address
   ];



    }

    public function getAllCity($city){
   
   $city_name=[];
   foreach ($city as $key => $value) {
    $city_name[$key]['id']=$value->id;
     $city_name[$key]['name']=$value->city_name;
   }
   
      return[
              $city_name
      ];
    }
    public function getAllCountry($country){
     $country_name=[];
    foreach ($country as $key => $value) {
     $country_name[$key]['id']=$value->id;  
     $country_name[$key]['name']=$value->country_name;
   }
   
      return[
              $country_name
      ]; 
    }
    public function getAllState($state)
     {
   
   $state_name=[];
   foreach ($state as $key => $value) {
    $state_name[$key]['id']=$value->id;
     $state_name[$key]['name']=$value->state_name;
   }
   
      return[
              $state_name
      ];
     }

     public function product_transform($product,$percent){
  // dd($percent);
     // if(empty($percent)){
    //$percent=0;
      //}else{
    	$percent=$percent[0];
//}  
       $variants=[];
       //dd($product['get_product_variant']);
   foreach ($product['get_product_variant'] as  $key => $val) {
  
       $variants[$key]['variants_id']=$val['id'];
       $variants[$key]['type']=$val['combination'];
       $variants[$key]['price']=$val['price'];
       $variants[$key]['type_image']=unserialize($val['image']);
       $variants[$key]['quantity']=$product['get_quantity_of_product'][$key]['quantity'];
       $variants[$key]['rates'] = $this->getRatesBlock($val,$percent);
      
        }
       
      
      
      
    return[
      'id'=>$product['id'],
       'name'=>$product['product_name'],
       'details'=>$product['product_description'],
       'photo'=>unserialize($product['image']),
        'minimum_rate'=>$product['min_price'],
        'maximum_rate'=>$product['max_price'],  
        
       'variants' => $variants,
       
       'brand_name'=>$product['brand']['brand_name'],
       'brand_deatils'=>$product['brand']['brand_description']    
       ];
   
}

public function cartDataOfuser($product,$percent){
//dd($product);
  $product_data=[];
foreach ($product as  $key => $value) {

  foreach ($value['get_product_variant'] as  $keys => $val) {

       $variants[$key]['variants_id']=$val['id'];
       $variants[$key]['type']=$val['combination'];
       $variants[$key]['price']=$val['price'];
       $variants[$key]['type_image']=unserialize($val['image']);
       $variants[$key]['quantity']=$value['get_quantity_of_product'][0]['quantity'];
       $variants[$key]['rates'] = $this->getRatesBlock($val,$percent[$key]);
      
        }
         $product_data[$key]['name']=$value['product_name'];
         
         $product_data[$key]['cart_qauntity']=$value['cart_qauntity'];
     $product_data[$key]['photo']=$value['image'];
     $product_data[$key]['minimum_rate']=$value['min_price'];
     $product_data[$key]['brand_name']=$value['brand'];
     $product_data[$key]['variants']=$variants[$key];
    
      }

//dd()
   return[
      //  'name'=>$product[0]['product_name'],
      
      //  'photo'=>$product[0]['image'],
      //   'minimum_rate'=>$product[0]['min_price'],
      // 'brand_name'=>$product[0]['brand'],
        $product_data
       //'variants' => $variants
       
          
       ];


}
public function wishlistDataOfuser($product,$percent){
  
  $product_data=[];
foreach ($product as  $key => $value) {

  foreach ($value['get_product_variant'] as  $keys => $val) {
  
       $variants[$key]['variants_id']=$val['id'];
       $variants[$key]['type']=$val['combination'];
       $variants[$key]['price']=$val['price'];
       $variants[$key]['type_image']=unserialize($val['image']);
       //$variants[$key]['quantity']=$value['get_quantity_of_product'][0]['quantity'];
       $variants[$key]['rates'] = $this->getRatesBlock($val,$percent[$key]);
      
        }
         $product_data[$key]['name']=$value['product_name'];
     $product_data[$key]['photo']=$value['image'];
     $product_data[$key]['minimum_rate']=$value['min_price'];
     $product_data[$key]['brand_name']=$value['brand'];
     $product_data[$key]['variants']=$variants[$key];
    
      }

 
   return[
      //  'name'=>$product[0]['product_name'],
      
      //  'photo'=>$product[0]['image'],
      //   'minimum_rate'=>$product[0]['min_price'],
      // 'brand_name'=>$product[0]['brand'],
        $product_data
       //'variants' => $variants
       
          
       ];


}
public function getRatesBlock($product,$percent)
{

     if(!isset($product['min_price']))
     $rate =  $product['price'];
     else 
     $rate =  $product['min_price'];  
    
      return [
        'actual_price' => $rate,
        'sale_price' => ($rate*(100-$percent['percent'])/100),
        'discount_in_percentage'=> $percent['percent'] 

       ];


}

public function path_transform($path){
   $link=[];
   
  foreach ($path as $key => $value) {
    $link[$key]="/api/path_data/".$key;
  }
  
   return[
    'root'=>$path,
    'link'=>$link,

   ];
}
public function brand_transform($brand){
  $allbrand=[];
  foreach ($brand as $key => $value) {
   $allbrand[$key]=$value['brand_name'];
  
  }
  return[
    'names'=>$allbrand
    
  ];
}
public function varitant_transform($variant){
  
  // $variant_name=[];
  // $variant_value=[];
  // foreach ($variant as $key => $value) {
  //   $variant_name[$key]=$value['variant_name'];
  //   if(!$value['value']){
  //     return;
  //   }
  //   foreach ($value['value'] as $k => $val) {
  //     $variant_value[$value['variant_name']][$k]=$val['variant_value'];
    
  //   }
  // // }
  // echo "<pre>";
  // print_r($variant);
  // echo "</pre>";
  // exit();
  $arr=[];
  foreach ($variant as $key => $val) {
    
    foreach ($val as $keys => $value) {
      //dd($value->id);
     $arr[$key][$value->id]=$value->variant_value; 
    }
  }
  // foreach ($variant as $key => $value) {
    
  // }
  // echo "<pre>";
  // print_r($arr);
  // echo "</pre>";
  // exit();
 
  return[
   $arr
  // 'value'=>$variant_value

  ];
}
public function offer_transform($offer){
 

  if(!$offer){
    return;
  }
  return $offer;
}
}