<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\anglara\Transformers\Subtransformer;
use App\Product;
use App\ProductCategory;
use App\Brand;
use App\Variants;
use App\Product_variant;
use App\Product_details;
use App\ProductOffer;
use Carbon\Carbon;
use App\Cart;
use App\CategoryOffer;
use App\User;
use App\Wishlist;
//use DB;
// use App\ApiController;
class SearchProduct extends ApiController
{
    protected $Transformer;
    function __construct(Subtransformer $Transformer){
       $this->Transformer=$Transformer;
    } 
    public function create(){
    	return view('/search_product.create');
    }
    //get all category
    public function getallcategory()
    {
      $category=ProductCategory::all();
      $arr=[];
     $extreme_parent=[];
      foreach ($category as $key => $value) {
       if($value->parent_category==0){
           $extreme_parent[$value->id]=$value->category_name;
         }
       $arr[$value->category_name]=$this->getallchild($category,$value->id);
       

      
      }

     
      return $this->respond([
        'data'=>$this->Transformer->getallcategory_transform($arr,$extreme_parent),
     
   ]);
    }
public function getallchild($category,$id)
{
  $arr=[];
  foreach ($category as $key => $value) {
   
   if($value->parent_category==$id){
    
    $arr[$value->id]=$value->category_name;
   }
  }
  if(count($arr)==0){
    return NULL;
  }else{
    return $arr;
  }
  
}
    //this for show product information only
   public function search_product(Request  $request){
      //dd($request->search);
     $search_id=[];
    $category=ProductCategory::where('category_name',$request['search'])->first();
    $b=0;
   
    if($category){
      $product=Product::where('category_id',$category->id)->first();
      if($product){
     array_push($search_id,$category->id);
      
      
   }
     else{
      $b=$category->id;
      $subcategory=ProductCategory::where('parent_category',$category->id)->get()->toArray();
     foreach ($subcategory as $key => $value) {
      array_push($search_id,$value['id']); 
     }
      
   
     }

    }

    $brand=Brand::where('brand_name',$request['search'])->first();
    if($brand){
    array_push($search_id,$brand->category_id);	
    }

   	$product=Product::where('product_name',$request['search'])->first();
    if($product){
    	array_push($search_id,$product->category_id);	
    } 
     if(!$search_id){
    
           return $this->respondNotFound("Product not found !");
    
     }
     
     if($b==0){
    $path=$this->path($search_id);  }
    else{
       $p=[];
    array_push($p,$b);
      $path=$this->path($p);
    }
   return $this->show($search_id,$path);
   }
   
  // public function find_min_of_min($product){
  //     $min=0;
  //     foreach ($product as $key => $value) {
  //       if($value['min_price'])
  //     }
  // }
  // public function find_max_of_max(){
    
  // }

    public function filter(Request $request){
   
    $cat=$request['cat_id'];
    $min=$request['min'];
    $max=$request['max'];
    $variant_type=$request['variant'];
   
   $brand=$request['brand'];
   $brand_id=[];
   if($brand){
     $selected_brand=Brand::whereIn('brand_name',$request['brand'])->get();
     $brand_id=$selected_brand->pluck('id')->toArray();
     
   
     }
   
   if($variant_type){
    $variant_id=[];
    foreach ($variant_type as $key => $value) {
      $variantss=[];
      
      if($request[$value]){
       foreach ($request[$value] as $key => $val) {
      
         array_push($variantss,$val);

      }
       if($variant_id){
         

        $value=Product_details::with('value')->whereHas('value', function($query) use($variantss){

      $query
      ->whereIn('variant_value',$variantss);
       
// pending part
    })->whereIn('product_variant_id',$variant_id)->get();

    $variant_id=$value->pluck('product_variant_id')->toArray();

       }else{
      $value=Product_details::with('value')->whereHas('value', function($query) use($variantss){

      $query
      ->whereIn('variant_value',$variantss);
       
// pending part
    })->get();

    $variant_id=$value->pluck('product_variant_id')->toArray();
    }

    }
    
    }
    

    $product=Product::with(['getProductVariant'=>function($query) use($variant_id){$query->whereIn('id',$variant_id);}])

    ->where('category_id',$cat)

    ->when($min,function($query,$min){ return $query->where('min_price','>=',$min);})

      ->when($max,function($query,$max){ return $query->where('max_price','<=',$max);})

      ->when($brand_id,function($query,$brand_id){ return $query->whereIn('brand_id',$brand_id);})
        ->get();
   }else{
    $product=Product::with('getProductVariant','brand')
    
    ->where('category_id',$cat)
    
    ->when($min,function($query,$min){ return $query->where('min_price','>=',$min);})
    
    ->when($max,function($query,$max){ return $query->where('max_price','<=',$max);})
    ->get();

 }

   
    $arr=$product->pluck('id')->toArray();
       
     $percent=$this->get_discount_percent($arr);
    
     if($request['discount']){
      $arrt=[];
      foreach ($request['discount'] as $keyy => $discount) {
      foreach ($percent as $key => $value) {
        if($value['percent']>=$discount){
          $arrt[$key]['percent']=$value['percent'];
        }
      }
      }
    
      $percent=$arrt;
     }

     if(!$percent){
          $temp_arr=[];
          foreach ($product as $key => $val) {
           
          
    $price=Product_variant::where('product_id',$val['id'])->get();
        
          
          foreach ($price as $key => $value) {
            $temp_arr[$key]['percent']=0;

          }
          
  
        }
        $percent=$temp_arr;
        }
      
         return $this->respond([
   'data'=>array_filter($this->Transformer->transformCollectionfilter($product->toArray(),$percent))
   
    ]);
    }
    //passing by product id to get offer information
    public function get_discount_percent(Array $id){
     
     $today=Carbon::now()->format('Y-m-d H:i:s');
    $product=Product::whereIn('id',$id)->get();
    
    $arr=[];
    foreach ($product as $key => $value) {
    $off_cat=CategoryOffer::where('category_id',$value['category_id'])->where('validity_From','<=',$today)->where('validity_To','>=',$today)->first();  
  
    if($off_cat){
    $arr[$key]['percent']=$this->find_amount_or_percent($off_cat->type,$off_cat->offer_amount,$value['min_price']);
    }
    else{
      $off=ProductOffer::where('product_id',$value['id'])->where('validity_From','<=',$today)->where('validity_To','>=',$today)->first();
      
      if($off){
           $arr[$key]['percent']=$this->find_amount_or_percent($off->type,$off->offer_amount,$value['min_price']);   
      }
     }

    }
    

     
  
        return $arr;
    
     
     
    }
    //passing type like flate of percentage and ammout is like offer of each product and $min price is like price 
    public function find_amount_or_percent($type,$amount,$min_price){
      
      if($type=="percentage"){
         $discount=$amount;
       }else{
          $discount=($amount/$min_price)*100;  
        }
        return $discount;
    }

    public function get_offer_percentage($product,$offer){
     $arr=[];
     foreach ($product as $key => $value) {
      foreach ($offer as $keys => $val) {
       if($value['id']==$val['product_id']){
       if($val['type']=="percentage"){
         $arr[$keys]['percent']=$val['offer_amount'];
       }else{
          $arr[$keys]['percent']=($val['offer_amount']/$value['min_price'])*100;  
        }
       }
      }

     }
  
return $arr;
   }
   //here array request is category id
    public function show(Array $request,Array $path){
    	
    	$product=Product::whereIn('category_id',$request)->get();

       $brand=$this->get_brand($request);
       $variant=$this->get_variant($request);
       $arr=$product->pluck('id')->toArray();
       
        $percent=$this->get_discount_percent($arr);

        $offer=[];
      
        if(!$percent){
          $temp_arr=[];
          foreach ($product as $key => $val) {
           
          
    $price=Product_variant::where('product_id',$val['id'])->get();
        
          
          foreach ($price as $key => $value) {
            $temp_arr[$key]['percent']=0;

          }
          
  
        }
        $percent=$temp_arr;
        }

      //dd($variant[0]['value']);
    	//return view('search_product.show',compact('product','offer','path','brand','variant','request'));
   return $this->respond([
     'data'=>$this->Transformer->transformCollection($product->toArray(),$percent),
     'path'=>$this->Transformer->path_transform($path),
     'brand'=>$this->Transformer->brand_transform($brand->toArray()),
     'variant'=>$this->Transformer->varitant_transform($variant),
     //'offer'=>$this->Transformer->offer_transform($offer)
   ]);
    }
       //return $this->Transformer->transformCollection($product->toArray());
      
   

    
    public function get_variant(Array $request){
      //dd($request);
      $arr=[];
    $variant=DB::table('variants')
    ->join('variant__values','variant__values.variant_id','=','variants.id')
    ->whereIn('variants.category_id',$request)->get();
   $data=$variant->groupBy('variant_name');
//dd($variant->all());
    // echo "<pre>";
    // print_r($date);
    // echo "</pre>";
    // exit();
    // $variant_details=Variants::whereIn('category_id',$request)->get();
    //   dd($name);
    //  $variant_id=$variant_details->pluck('id')->toArray();
    //  $value=variant_value::whereIn('variant_id',$variant_id)->get();
    //  foreach ($variant_details as $key => $var) {
    //    foreach ($value as $keys => $val) {
    //      $arr[$var['variant_name']][$keys]=$val['variant_value'];
    //    }
    //  }
   //    $product=Product::with('getProductVariant')->whereIn('category_id',$request)->get();
   //    foreach ($product as $key => $p) {
   //        foreach ($p->getProductVariant as $key => $value) {
   //            array_push($arr, $value->id);
   //        }
   //    }
   //  $details=Product_details::whereIn('product_variant_id',$arr)->get()->toArray();
   // $value_id=[];
   //  foreach ($details as $key => $value) {
   //     array_push($value_id, $value['value_id']);
   //  }

   //     $variant=Variants::with(['value'=>function ($query) use($value_id){$query->whereIn('id',$value_id);}])->get();

       return $data;
    }
     //here array request is category id
    public function get_brand(Array $request){
        return Brand::whereIn('category_id',$request)->get();
    }
    //path of the catergory
    public function path(Array $request){
     
    
     $path=[];
    
    $temp=$request[0];

    while($temp<=$request[0] && $temp>0){
    $cat=ProductCategory::where('id',$temp)->first();
   
    //key as id of product category and value name of the category
    $path[$cat->id]=$cat->category_name;

    $temp=$cat->parent_category;

  

    }
    $index=array_reverse(array_keys($path));
    	
    $path=array_reverse($path);
    $path=array_combine($index, $path);
    
    return $path;
     //return view('search_product.show',compact('product','path'));  
    }
    //get particular category data
   public function path_data(Request $request){
   
   	$category=ProductCategory::where('parent_category',$request['id'])->get();
   	
   	  $temp=[];
   	  foreach ($category as $key => $value) {
   	  	array_push($temp, $value->id);
   	  }
   	  if(empty($temp)){
        	
        	return redirect()->back();
        }

   	 return $this->product_for_each_category($request,$temp);

    }
    //getting each category data
    public function product_for_each_category(Request $request,Array $temp){
    	
    	$where=[];
        //getting all id of the category of sub category
    	foreach ($temp as $key => $value) {
    		
    	$query=Product::where('category_id',$value)->first();
       if($query){

    		if($where){
    		array_push($where,$value);
    	}
    	else{
    		array_push($where,$value);
    	}

    	}
    		
    	}
    
          //to path till that category
    	$p=[];
       array_push($p,$request['id']);
       $path=$this->path($p);
         
    	
    return $this->show($where,$path);
    }
    //getting price in increase order
    public function getAscendingPrice(Request $request){
   //first selecting a same path
        $p=[];
       array_push($p,$request['id']);
       $path=$this->path($p);
       //gettigg all product id that was displayed
       $product=Product::where('category_id',$request['id'])->orderBy('min_price','asc')->get();
       $brand=$this->get_brand($p);
       $variant=$this->get_variant($p);
       $request=$p;
       $arr=$product->pluck('id')->toArray();
        $percent=$this->get_discount_percent($arr);
       
       //return view('search_product.show',compact('product','path','brand','variant','offer'));
       return $this->respond([
        'data'=>$this->Transformer->transformCollection($product->toArray(),$percent),
     'path'=>$this->Transformer->path_transform($path),
     'brand'=>$this->Transformer->brand_transform($brand->toArray()),
     'variant'=>$this->Transformer->varitant_transform($variant),
     //'offer'=>$this->Transformer->offer_transform($offer)
       ]);
    }

    //getting price in decrease order
    public function getDescendingPrice(Request $request){
      //getting path 
      $p=[];
       array_push($p,$request['id']);
       $path=$this->path($p);
       //getting product Id that was dispalyed
       $product=Product::where('category_id',$request['id'])->orderBy('min_price','dsc')->get();
     
       
       
         $brand=$this->get_brand($p);
       $variant=$this->get_variant($p);
       $request=$p;
       $arr=$product->pluck('id')->toArray();
         $percent=array_reverse($this->get_discount_percent($arr));
//dd($percent);
       //return view('search_product.show',compact('product','path','brand','variant','offer'));
    // return $this->respond([
    //     'data'=>$this->Transformer->transformCollection($product->toArray(),$percent),
    //  'path'=>$this->Transformer->path_transform($path),
    //  'brand'=>$this->Transformer->brand_transform($brand->toArray()),
    //  'variant'=>$this->Transformer->varitant_transform($variant),
    //  //'offer'=>$this->Transformer->offer_transform($offer)
    //    ]);
         return $this->respond([
     'data'=>$this->Transformer->transformCollection($product->toArray(),$percent),
     'path'=>$this->Transformer->path_transform($path),
     'brand'=>$this->Transformer->brand_transform($brand->toArray()),
     'variant'=>$this->Transformer->varitant_transform($variant),
     //'offer'=>$this->Transformer->offer_transform($offer)
   ]);
    }

    //find latest product details
    public function getNewest_product(Request $request){
  //getting path 
      $p=[];
       array_push($p,$request['id']);
       $path=$this->path($p);
       //getting all product in descending order by id because the we want LIFO (last in first output so), that are associated with searched category 
       $product=Product::where('category_id',$request['id'])->orderBy('id','dsc')->get();
     
     $brand=$this->get_brand($p);
       $variant=$this->get_variant($p);
       //this is for filter requetstts
       $request=$p;

       $arr=$product->pluck('id')->toArray();
        $percent=array_reverse($this->get_discount_percent($arr));
      
     //return view('search_product.show',compact('product','path','brand','variant','offer'));
 return $this->respond([
         'data'=>$this->Transformer->transformCollection($product->toArray(),$percent),
     'path'=>$this->Transformer->path_transform($path),
     'brand'=>$this->Transformer->brand_transform($brand->toArray()),
     'variant'=>$this->Transformer->varitant_transform($variant),
     //'offer'=>$this->Transformer->offer_transform($offer)
       ]);
    }
    
    public function get_product_details(Request $request){
      $id=$request['id'];
      
      $product=Product::with('getProductVariant','brand','getQuantityOfProduct')->where('id',$id)->first();
      
      
   if(!$product){
    
           return $this->respondNotFound("Product not found !");
    
     }

        $p=[];
        
       array_push($p,$product->category_id);     
  //getting cat id from product and then take all variant and value ,other hand 
//we have product variant id so we get all value id for details table 
//then we take final data by matching these id.

       //$variants=$this->get_variant($p);        
     
    // dd($variants);
    $del_variant_id=Product_variant::where('product_id',$product->id)->pluck('id')->toArray();
    
    $details_value_id=Product_details::whereIn('product_variant_id',$del_variant_id)->pluck('value_id')->toArray();
    
    $variants=DB::table('variants')
    ->join('variant__values','variant__values.variant_id','=','variants.id')
    ->whereIn('variants.category_id',$p)->whereIn('variant__values.id',$details_value_id)->get();
  
    $final_variant=$variants->groupBy('variant_name');
   //dd($final_variant);
       // step for path like which category product fall 
       $path=$this->path($p);
        
       $arr=[0=>$request->id];

     
     
        $percent=$this->get_discount_percent($arr);
     

        if(!$percent){
          $price=Product_variant::where('product_id',$id)->get();
        
          $temp_arr=[];
          foreach ($price as $key => $value) {
            $temp_arr[$key]['percent']=0;

          }
          $percent=$temp_arr;
  
        }

  

 return $this->respond([
        'data'=>$this->Transformer->product_transform($product->toArray(),$percent,$final_variant),
         'path'=>$this->Transformer->path_transform($path),
         'variant_value'=>$this->Transformer->varitant_transform($final_variant),
 //        //'offer'=>$this->Transformer->offer_transform($offer)
     
     ]);
    }

    //card data storing part
    //its form like data here requiered uesr->(exiets)user_id,type->product Variant id and quantity
 public function cartDataStore(Request $request)
    {
      $token_parts = explode('.', $request['token']);
      $token_header = $token_parts[1];
      
      //dd($token_header);
      // base64 decode to get a json string
      $token_header_json = base64_decode($token_header);
      
      // you'll get this with the provided token:
      // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
      
      // then convert the json to an array
      $token_header_array = json_decode($token_header_json, true);
      $user = User::find($token_header_array['sub']);
     // dd($user);
   // $user=User::where('id',$request['user'])->first();
        if(!$user){
          return $this->respondForUnauthorized("Unauthorized Request ,user not find");
        }


      $c=Cart::where('product_variant_id',$request['type'])->first();
      if($c){
        //if user id and variant and product same then user select item then quantity will increase only
          $c->quantity=$c->quantity+$request['quantity'];
          $c->save();
          return $this->respondForAccepted("Sucessfully data added in Cart.");
      }

      else{
        $variant=Product_variant::where('id',$request['type'])->first();
        if(!$variant){
          return $this->respondForUnauthorized("Combination not fine");
        }
        
        
      $cart=Cart::create([
      'quantity'=>$request['quantity'],
      'product_id'=>$variant->product_id,
      'product_variant_id'=>$variant->id,
      'user_id'=>$user->id
      ]);
     
if($cart){
  return $this->respondForAccepted("Sucessfully data added in Cart.");
}

}


}



//here getting cart data of particuler user 
//here required only existing user -> user id 
public function showAllCartDataByuserId(Request $request){
  $token_parts = explode('.', $request['token']);
  $token_header = $token_parts[1];
  
  //dd($token_header);
  // base64 decode to get a json string
  $token_header_json = base64_decode($token_header);
  
  // you'll get this with the provided token:
  // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
  
  // then convert the json to an array
  $token_header_array = json_decode($token_header_json, true);
  $user = User::find($token_header_array['sub']);
  if(!$user){
    return $this->respondForUnauthorized("User not find");
  }
$cart=Cart::where('user_id',$user->id)->get();

if(!count($cart)){
    
           return $this->respondNotFound("No Cart data available");
    
     }

$temp_product=[];
$pp=[];


foreach ($cart as $key => $value) {
 //dd($value['quantity']);
 $quant=$value['quantity'];
  $try=[0=>$value['product_variant_id']];
  
  $prod=Product::with(['getProductVariant'=>function($query) use($try)
          {
            $query->whereIn('id',$try);
          }]
        )->with(['getQuantityOfProduct'=>function($query) use($try)
          {
            $query->whereIn('product_variant_id',$try);
          }])
        ->with('brand')->
        where('id',$value['product_id'])
        ->first();

$arr_quantity=0;
foreach ($prod->getQuantityOfProduct as $key => $value) {
   $arr_quantity=$value->quantity;
   }

        $arr_variant=[];
foreach ($prod->getProductVariant as $key => $value) {
   $arr_variant['id']=$value->id;
   $arr_variant['combination']=$value->combination;
   $arr_variant['price']=$value->price;
   $arr_variant['image']=$value->image;
}
  
       
        $arr_fill=[];
       $arr_fill['product_name']=$prod->product_name;
       $arr_fill['cart_qauntity']=$quant;
       $arr_fill['image']=$prod->image;
       $arr_fill['min_price']=$prod->min_price;
       $arr_fill['brand']=$prod->brand->brand_name;
       $arr_fill['get_product_variant'][$key]=$arr_variant;
       $arr_fill['get_quantity_of_product'][$key]['quantity']=$arr_quantity;

array_push($temp_product,$arr_fill);
        $arr=['0'=>$value['product_id']];
  $per=$this->get_discount_percent($arr);
  

         if(!$per){
           $price=Product_variant::where('id',$value['product_variant_id'])->whereIn('product_id',$arr)->first();
        
           $temp_arr=[];
         
            $temp_arr[$key]['percent']=0;

         
           $per=$temp_arr;
  
     }
     array_push($pp, $per);
        
}
$product=$temp_product;

$percent=[];
foreach ($pp as $key => $value) {
 foreach ($value as $keys => $values) {
   $percent[$key]['percent']=$values['percent'];
 }
}

     
   
    
       return $this->respond([
        'data'=>$this->Transformer->cartDataOfuser($product,$percent)
        
         
     ]);
       
    }
    //edit card data  here requierd data is variant id(type) and user id(user) and updated quantity 
    public function EditCartDataByuserId(Request $request){
   //dd($request->all());
   $token_parts = explode('.', $request['token']);
    $token_header = $token_parts[1];
    
    //dd($token_header);
    // base64 decode to get a json string
    $token_header_json = base64_decode($token_header);
    
    // you'll get this with the provided token:
    // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
    
    // then convert the json to an array
    $token_header_array = json_decode($token_header_json, true);
    $user = User::find($token_header_array['sub']);
    if(!$user){
      return $this->respondForUnauthorized("Unauthorized Request");
    }
      $cart=Cart::where([['user_id',$user->id],['product_variant_id',$request['type']]])->first();
    if(!$cart){
return $this->respondNotFound("No Cart data available");
    }
      $cart->quantity=$request['quantity'];
      $cart->save();

      return $this->respondForAccepted("Sucessfully,Cart Data edited.");


    }
//remove particular cart data of particular user here requierd data is variant id and user id 
    public function DeleteCartDataByuserId(Request $request){
      $token_parts = explode('.', $request['token']);
    $token_header = $token_parts[1];
    
    //dd($token_header);
    // base64 decode to get a json string
    $token_header_json = base64_decode($token_header);
    
    // you'll get this with the provided token:
    // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
    
    // then convert the json to an array
    $token_header_array = json_decode($token_header_json, true);
    $user = User::find($token_header_array['sub']);
      //$user=User::where('id',$request['user'])->first();
        if(!$user){
          return $this->respondForUnauthorized("Unauthorized Request");
        }
      $cart=Cart::where([['user_id',$user->id],['product_variant_id',$request['type']]])->first();
    if(!$cart){
return $this->respondNotFound("No Cart data available");
    }
      $cart->delete();
return $this->respondForAccepted("Sucessfully,Cart Data Removed.");      

    }

    //create wishlist here requiered data user id as user and product variant id as type
    public function createWishlist(Request $request){
      
      $token_parts = explode('.', $request['token']);
      $token_header = $token_parts[1];
      
      //dd($token_header);
      // base64 decode to get a json string
      $token_header_json = base64_decode($token_header);
      
      // you'll get this with the provided token:
      // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
      
      // then convert the json to an array
      $token_header_array = json_decode($token_header_json, true);
      $user = User::find($token_header_array['sub']);
     // dd($user);
   // $user=User::where('id',$request['user'])->first();
        if(!$user){
          return $this->respondForUnauthorized("Unauthorized Request ,user not find");
        }
      // $user=User::where('id',$request['user'])->first();
      //   if(!$user){
      //     return $this->respondForUnauthorized("Unauthorized Request");
      //   }
      $list=Wishlist::where([
        ['user_id',$user->id],
        ['product_variant_id',$request['type']]
      ])->first();
 
      if($list){
    return $this->respondForAccepted("Already,wishlist Data added.");      
      }else{
        $variant=Product_variant::where('id',$request['type'])->first();
        $wishlist=Wishlist::create([
      'product_id'=>$variant->product_id,
      'product_variant_id'=>$request['type'],
      'user_id'=>$user->id
        ]);

        if($wishlist){
  return $this->respondForAccepted("Sucessfully, data added in Wishlist.");
}else{
  return $this->respondForAccepted("Data not added in Wishlist.");
}

      }

    }
//here requiered only user is as user ,to show all data of particuler user
public function showAllWishList(Request $request){
  $token_parts = explode('.', $request['token']);
  $token_header = $token_parts[1];
  
  //dd($token_header);
  // base64 decode to get a json string
  $token_header_json = base64_decode($token_header);
  
  // you'll get this with the provided token:
  // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
  
  // then convert the json to an array
  $token_header_array = json_decode($token_header_json, true);
  $user = User::find($token_header_array['sub']);
  
  if(!$user){
    return $this->respondForUnauthorized("User not find");
  }
$list=Wishlist::where('user_id',$user->id)->get();

if(!count($list)){
    
           return $this->respondNotFound("No Wishlist data available");
    
     }

$temp_product=[];
$pp=[];


foreach ($list as $key => $value) {
 
  $try=[0=>$value['product_variant_id']];
  
  $prod=Product::with(['getProductVariant'=>function($query) use($try)
          {
            $query->whereIn('id',$try);
          }]
        )->with('brand')->
        where('id',$value['product_id'])
        ->first();




        $arr_variant=[];
foreach ($prod->getProductVariant as $key => $value) {
   $arr_variant['id']=$value->id;
   $arr_variant['combination']=$value->combination;
   $arr_variant['price']=$value->price;
   $arr_variant['image']=$value->image;
}
 
       
        $arr_fill=[];
       $arr_fill['product_name']=$prod->product_name;
       
       $arr_fill['image']=$prod->image;
       $arr_fill['min_price']=$prod->min_price;
       $arr_fill['brand']=$prod->brand->brand_name;
       $arr_fill['get_product_variant'][$key]=$arr_variant;
      

array_push($temp_product,$arr_fill);
        $arr=['0'=>$value['product_id']];
  $per=$this->get_discount_percent($arr);
  

         if(!$per){
           $price=Product_variant::where('id',$value['product_variant_id'])->whereIn('product_id',$arr)->first();
        
           $temp_arr=[];
         
            $temp_arr[$key]['percent']=0;

         
           $per=$temp_arr;
  
     }
     array_push($pp, $per);
        
}
$product=$temp_product;

$percent=[];
foreach ($pp as $key => $value) {
 foreach ($value as $keys => $values) {
   $percent[$key]['percent']=$values['percent'];
 }
}

     
   //dd($product);
    
       return $this->respond([
        'data'=>$this->Transformer->wishlistDataOfuser($product,$percent)
        
         
     ]);

    }

  //now after showing wish list we have to add into card to particualr user so here requiered data user id as user and variant id as type
    public function wishlistAddToCartDataByuserId(Request $request){
      


      $token_parts = explode('.', $request['token']);
      $token_header = $token_parts[1];
      
      //dd($token_header);
      // base64 decode to get a json string
      $token_header_json = base64_decode($token_header);
      
      // you'll get this with the provided token:
      // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
      
      // then convert the json to an array
      $token_header_array = json_decode($token_header_json, true);
      $user = User::find($token_header_array['sub']);
    //$user=User::where('id',$request['user'])->first();
          if(!$user){
            return $this->respondForUnauthorized("Unauthorized Request");
          }
$list=Wishlist::where([['user_id',$user->id],['product_variant_id',$request['type']]])->first();

    if(!$list){
return $this->respondNotFound("No Wishlist data available!");
    }    


      $c=Cart::where('product_variant_id',$request['type'])->first();
      if($c){
        //if user id and variant and product same then user select item then quantity will increase only
         
          return $this->respondForAccepted("Product Already available in Cart.");
      }

      else{
        $variant=Product_variant::where('id',$request['type'])->first();
        
        
       
      $cart=Cart::create([
      'quantity'=>1,
      'product_id'=>$variant->product_id,
      'product_variant_id'=>$variant->id,
      'user_id'=>$user->id
      ]);
     

// $list=Wishlist::where([['user_id',$cart->user_id],['product_variant_id',$cart->product_variant_id]])->first();
// //dd($list);
//     if(!$cart){
// return $this->respondNotFound("No Cart data available");
//     }
           




if($cart){
  
   $list->delete();
return $this->respondForAccepted("Wishlist data sucessfully added in Cart.");
}

}

     
    }
//here sort deleting wishlist product of particular user and particular product here required data varaint id as type and user id as user 
public function DeleteWishlistDataByuserId(Request $request){
    // dd("hi");
    $token_parts = explode('.', $request['token']);
    $token_header = $token_parts[1];
    
    //dd($token_header);
    // base64 decode to get a json string
    $token_header_json = base64_decode($token_header);
    
    // you'll get this with the provided token:
    // {"typ":"JWT","alg":"RS256","jti":"9fdb0dc4382f2833ce2d3993c670fafb5a7e7b88ada85f490abb90ac211802720a0fc7392c3f2e7c"}
    
    // then convert the json to an array
    $token_header_array = json_decode($token_header_json, true);
    $user = User::find($token_header_array['sub']);
  //$user=User::where('id',$request['user'])->first();
        if(!$user){
          return $this->respondForUnauthorized("Unauthorized Request");
        }
  $list=Wishlist::where([['user_id',$user->id],['product_variant_id',$request['type']]])->first();
    if(!$list){
return $this->respondNotFound("No Wishlist data available");
    }
      $list->delete();
return $this->respondForAccepted("Sucessfully,wishlist Data Removed.");      
    }
    }
