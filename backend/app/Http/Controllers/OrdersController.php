<?php

namespace App\Http\Controllers;

use App\Orders;

use App\Address;

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
use App\QuantityOfProduct;
use Illuminate\Support\Str; 
use App\OrderStatus;
class OrdersController extends ApiController
{
    

protected $Transformer;
    function __construct(Subtransformer $Transformer){
       $this->Transformer=$Transformer;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       //dd($request->all());

        $order_id=strtoupper((new Str)->random($length=4)).rand(1000,9999).$request['user'];
        //$order_id=1000+$request['user'];


        //for loop for banch of order
        $user=User::find($request['user']);
        //dd($user);
        if(!$user){
          return $this->respondForNotAvailable("NO Responce");
        }
        
        
     $product=Product::find($request['product']);
        //dd($user);
        if(!$product){
          return $this->respondForBadRequest("Bad Request");
        }

        $variant=Product_variant::find($request['variant']);
        //dd($product->id);
        if(!$variant){
         return $this->respondForBadRequest("Bad Request");   
        }
        if($product->id!=$variant->product_id){
            return $this->respondForNotAvailable("Not Available");
        }
        $quantity=QuantityOfProduct::where([['product_id',$product->id],
        ['product_variant_id',$variant->id]
    ])->first();

        if($quantity->quantity<$request['numberOfitem']){
          return $this->respondForNotAcceptable("Not Acceptable Request");
        }
        
        $address=Address::find($request['deliver']);
        //dd($address->id);
        if(!$address){
            return $this->respondForNotAvailableOfLegalReason("Add Correct Address.");
        }
       $arr=[0=>$product->id];
       //dd($request->id);
       $percent=$this->get_discount_percent($arr);
       //dd($percent);
       if(!$percent){
          //$price=Product_variant::where('product_id',$id)->get();
        
          $temp_arr=[];
          //foreach ($price as $key => $value) {
            $temp_arr['percent']=0;

          //}
          $percent=$temp_arr;
}
   
if($percent['percent']!=$request['discount']){
   
    return $this->respondForBadRequest("Invaild Discount.");
}
//dd($percent['percent']);
   $price=$this->getRatesBlock($variant,$percent);
  //dd($price['sale_price']);
//if($request['price']!=$price['sale_price']){
  //  return $this->respondForPayment("Payment Error");
   // }
   //if()

     //dd($request['price']);
    $order=Orders::create([
    'user_id'=>$user->id,
    'product_id'=>$product->id,
    'product_variant_id'=>$variant->id,
    'address_id'=>$address->id,
    'quantity'=>$request['numberOfitem'],
    'unitprice'=>$price['sale_price']*$request['numberOfitem'],
    'approve_status'=>"Approved",
    'order_id'=>$order_id,
    'discount_percentage'=>$percent['percent']
    ]);
   
   if(!$order){
return $this->respondForNotAcceptable("Order Not Acceptable");
   }

   $quant=QuantityOfProduct::create([
        'quantity'=>$quantity->quantity-$order->quantity,
        'order_id'=>$order->id,
        'product_id'=>$order->product_id,
        'product_variant_id'=>$order->product_variant_id
           ]);

    if(!$quant){
        return $this->respondForOk("Quantity Not updated .");
        
    }
    //here default proceess_by=0 like when default process  
    $status=OrderStatus::create([
     'reference_Order_id'=>$order->id,
     'order_id'=>$order_id,
     'status'=>$order->approve_status,
     'process_by'=>0
    ]);
if(!$status)
{
    return $this->respondForNotAcceptable("OrderStatus Not updated");
}

   return $this->respondForAccepted("Order Successfully");

}

public function getRatesBlock($product,$percent)
{
//dd($percent['percent']);
     //if(!isset($product['min_price']))
     $rate =  $product['price'];
     //else 
     //$rate =  $product['min_price'];  
    
      return [
        
        'sale_price' => ($rate*(100-$percent['percent'])/100),
        

       ];


}

    public function find_amount_or_percent($type,$amount,$min_price){
      
      if($type=="percentage"){
         $discount=$amount;
       }else{
          $discount=($amount/$min_price)*100;  
        }
        return $discount;
    }

    public function get_discount_percent(Array $id){
      //dd($id);
     $today=Carbon::now()->format('Y-m-d H:i:s');
    $product=Product::whereIn('id',$id)->get();
    //dd($product);
    $arr=[];
    foreach ($product as $key => $value) {
    $off_cat=CategoryOffer::where('category_id',$value['category_id'])->where('validity_From','<=',$today)->where('validity_To','>=',$today)->first(); 
    
    if($off_cat){
    $arr[$key]['percent']=$this->find_amount_or_percent($off_cat->type,$off_cat->offer_amount,$value['min_price']);
    }
    else{
      $off=ProductOffer::where('product_id',$value['id'])->where('validity_From','<=',$today)->where('validity_To','>=',$today)->first();
      //dd($off);
      if($off){
           $arr[$key]['percent']=$this->find_amount_or_percent($off->type,$off->offer_amount,$value['min_price']);   
      }
     }

    }
    

     
  
        return $arr;
    
     
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
