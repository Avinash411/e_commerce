<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

use App\Brand;
use App\ProductCategory;
use App\Http\Requests\ProductUpdateValidation;
use App\Http\Requests\ProductValidation;
use Storage;
use Image;
use App\Variants;
use App\Variant_Value;
use App\Product_Variant;
use App\Product_details;
use App\QuantityOfProduct;
use App\Orders;
class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //its for edit page
    //this method stand for remove button like submit the form by jquery for image menegment like first select image by option then click on remove then going to delete form database as well as from upload folder.logic is like this passing hidden input id and remove array. 
     // public function index(){
     //    $p=Product::all();
     //    return Response::json([

     //       'data'=>$p->toArray()
     //    ]);
     // }
    public function remove_image_edit_process()
    {
       //its store id of the product.
        $id=$_POST['id'];
        //its store index of the database array which is selected.
        $remove=$_POST['remove'];
  
        //createing object of product class  
        $product=Product::find($id);
        //we already stored in serialized form so for apply logic first we have to unserialize it.so this
        $temp=unserialize($product->image);
         //now first find value the index and unset and unlink file by this. 
           foreach ($remove as $key => $value) {
            //check in database array if file is available then unlink it.            
                if(file_exists(public_path().'/Uploads/Product_images/'.$temp[$value])) {
                   unlink(public_path().'/Uploads/Product_images/'.$temp[$value]);
                   }
            //as well as deleting from databse.
            unset($temp[$value]);
                }     
            
     //after above process now we have new array of images name so serialize it and store it.
        $image=serialize($temp);
        $product->image=$image;
        $product->save();
        // redirecting back page from we click on remove.
       return redirect()->back();
       

    }
    //this is the process for remove vairiant image on edit page of th product
    public function variant_image_remove(Request $request){
       
       $remove=$request['variant_image_remove'];
        
        $variant=Product_Variant::find(array_keys($remove)[0]);

         $temp=unserialize($variant->image);
         
        foreach ($remove[$variant->id] as $key => $value) {

            //check in database array if file is available then unlink it.            
                if(file_exists(public_path().'/Uploads/Variants_image/'.$temp[$value])) {
                   unlink(public_path().'/Uploads/Variants_image/'.$temp[$value]);

                    //as well as deleting from databse.
            unset($temp[$value]);
                   }
           
        }
       
       $image=serialize($temp);
       $variant->image=$image;
        $variant->save();



        // redirecting back page from we click on remove.
       return redirect()->back();
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //In create product page we need dropdwon of brand and category 
        //creating brand object

        $brand=(new Brand)::all();
        //creating category object
        $category=(new ProductCategory)::all();
        //sending all variant  
        $variants=Variants::all();
        //here we send objects in view page by compact function
      return view('product_details.create',compact('brand'),compact('category','variants'));
    }
    //displaying associated variant value
    public function variant_value(){
        $id=$_POST['id'];
        $variant=Variants::find($id);
        $value=Variant_Value::where('variant_id',$id)->get();
        
        return view('product_details.variants_value',compact('value','id','variant'));
    }
    //create a combination of each variant value
    public function create_combination(Request $request){
        
         //creating array of array 
        $arr=$request->arr;
         
        //final array have all array to find combination
        $final = [];
        foreach($arr as $key => $b){
   if($b!=''){
        array_push($final, $b);
      }
          }
        //n is length of final array 
        $n=count($final);
        //creating a array with zero value for index management perpose
        $temp=[];
       for($i=0;$i<$n;$i++){
            $temp[$i]=0;
         }
  //     $final=array_filter($final);
  //     echo "<pre>";

  //  print_r($request->all());
  //  echo "</pre>";
  //     //dd($final);
  //     echo "<pre>";

  //  print_r($final);
  //  echo "</pre>";
  //  echo "<hr>";
  //  echo "<pre>";
  //  print_r($temp);
  //  echo "</pre>";
  //  echo "<hr>";
  //  echo "<pre>";
  //  print_r($arr);
  //  echo "</pre>";
  //  echo "<hr>";
  // exit();

        return view('product_details.combination',compact('final','temp','n','arr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //this is for image storing funct
    //temp for product imageion like we need in two time like we create product and when update product.
    //temp1 for simple image
    //here two argument one 
    //combination imagefor array and second from image (which image we want to store)
    private function image_store(Array $temp,Request $request){
          
    foreach ($request['picture'] as $value) {
     //single image name      
        $file=$value;
        //create new image name with product name,time and extensions
        $filename=$request['name'].time().'.'.$file->getClientOriginalName();
        //set path where you want to store new image with new name 
        $path=public_path('/Uploads/Product_images/' . $filename);
        //resize it save it
        Image::make($file)->resize(300,300)->save($path);
        ////in temp array we push new file name for store
          array_push($temp,$filename);
          
         }
         return $temp;
    }
    //image(multiple) store for each combination of variants 
    private function variant_image_store(Array $temp,Array $request){

        $j=0;
     foreach ($request as $value) {
    $file=$value;
    //j is only for naming perpose
    
     echo $filename=$j++.time().'_'.$file->getClientOriginalName();
     
    $path=public_path('/Uploads/Variants_image/' .$filename);
    Image::make($file)->resize(300,300)->save($path);
    array_push($temp,$filename);
    }
    return $temp;
    //exit();
    }



    public function store(ProductValidation $request)
    {   

       //dd($request['gg'][0]['attr'][0]);    
        //iniatially no image occur so we create a empty array to call to function 
        //to complete image uplaoding part
        //temp for product image 
            $temp = [];
            //temp1 for simple image
            $temp1=[];
            //combination image
           $img=[];
        //call the function only when user select image

         if(!empty($request['picture'])){
          //calling function  
           $temp=$this->image_store($temp,$request);
         }
         //storing data after validation in database
       $product = Product::create([
         'product_name'=>$request['name'],
         'product_description'=>$request['details'],
         //return array from image_store ,serialize it and store it.
         'image'=>serialize($temp),
         'category_id'=>$request['category'],
         'brand_id'=>$request['brand'] ,
         'min_price'=>0,
         'max_price'=>0
        ]);


       
//for simple product like we have to enter only sku and price

       if(!empty($request['rate'])){
        
        if(!empty($request['img'])){
            $img=$this->variant_image_store($img,$request['img']);
        }
        
        $product_variant_id_to=Product_variant::create([
        'product_id'=>$product->id,
        'combination'=>"",
        'image'=>serialize($img),
        'price'=>$request['rate'],
        'stock_keeping_unit'=>$request['sku']
        ]);
        
        app('App\Http\Controllers\QuantityOfProductController')->quantityStore($request['quantity'],0,$product->id,$product_variant_id_to->id);


       //its min price and max price of the product like when if only one price available so that //is min max
       $min=$request['rate'];
       $max=$request['rate'];

       }

    //its for combination variant add storing 
       //gg is array name which is sended from html page
    else{
        //consider min and amx price is same
        $min=$request['gg'][0]['price'];
          $max=$request['gg'][0]['price'];
        if(empty($request['gg'])){
          return redirect()->back()->withErrors(['abc'=>'Please Choose Valid  Variant.']);
        }
      for($i=0;$i<count($request['gg']);$i++){
       
         $add_img=[];
        if(!empty($request['gg'][$i]["file"])){
          //if file occur then going to store by variant_image_store and return array of name of 
          //files
            $add_img=$this->variant_image_store($add_img,$request['gg'][$i]["file"]);
        }
         //imloding function is use for converting array into string with join by "-"
        //each index
            $arr_tempy=[];

            foreach(array_filter($request['gg'][$i]['attr']) as $keyee=>$valueyy){
             foreach ($valueyy as $kk => $vval) {
               //dd($vval);
            
                array_push($arr_tempy,$vval);      
             
        
            }

            }
         $temp1=implode("-",array_filter($arr_tempy) );
          //finding min and max price
          if($min>$request['gg'][$i]['price']){
            $min=$request['gg'][$i]['price'];
          }
          if($max<$request['gg'][$i]['price']){
            $max=$request['gg'][$i]['price'];
          }

          //now entering all relevent data in to product variant table
          $p=Product_variant::create([
         'product_id'=> $product->id,
         'combination'=>$temp1,
         'stock_keeping_unit'=>$request['gg'][$i]['sku'],
         'price'=>$request['gg'][$i]['price'],
         'image'=>serialize($add_img)
        ]);

      app('App\Http\Controllers\QuantityOfProductController')->quantityStore($request['gg'][$i]['quantity'],0,$product->id,$p->id);

      


        //filling product details table by calling method
        // this array used to store each product variant of each product 
        // $arr_pro=[];
        // array_push($arr_new, $p->product_id);
        $arr_new=[];
        array_push($arr_new, $p->id);
        $this->product_details_field(array_filter($request['gg'][$i]['attr']),$arr_new);
        array_pop($arr_new);
      


      }
        
       }
       //updating product attribute like min and max
       $min_max=Product::find($product->id);
       $min_max->min_price=$min;
       $min_max->max_price=$max;

      $min_max->save();

        
    //by clicking submit type button user going to redirect it.
        if(isset($_POST['save']))
         { 
          session()->flash('notif','Successfully save product.');
            return redirect()->route('get:ProductController:show');
         }else
         {
          session()->flash('notif','Successfully save product.');
        return redirect()->route('get:ProductController:create');
     }
        
}
//storing all relevent data into product details table
public function product_details_field(Array $request,Array $Id){
 //here arr is array of all varinats value
  //print_r($request);
  //exit();
  //$product_id=Product_Variant::whereIn('id',$Id[0])->pluck('product_id')->toArray();
  //$cat_id=Product::whereIn('id',$product_id)->pluck('category_id')->toArray();
 // $variant_id_for_value=Variants::where('category_id',$cat_id)->pluck('id')->toArray();
       
 
 foreach ($request as $key => $value) {
 foreach ($value as $keyy => $val) {
//dd($val); ['status', '=', '1'],
  //  ['subscribed', '<>', '1'],
  $values=Variant_Value::where(
    [
      ['variant_id','=',$keyy],
    ['variant_value','=',$val]
    ]
  )->first();
 if($values){
   Product_details::create([
   'product_variant_id'=>$Id[0],
   'value_id'=>$values->id
  ]);
 }     

       
        }
    }  
       
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    //this show in table like all infomation
    public function show(Product $product)
    {
        $product=Product::with('brand','category')->get();
        //dd($product[0]->brand['id']);
        return view('product_details.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    //here taking product details with all brand and category if user wants to edit it.
    public function edit(Product $product)
    { 

         $id=array_keys($_GET);
         //dd($id);
        //products part
        $product=Product::whereIn('id',$id)->with('brand','category')->first();
        $allbrand=Brand::where('id','!=',$product->brand_id)->get();
        $allcategory=ProductCategory::where('id','!=',$product->category_id)->get();
       //variants part
       $variantss=Product_variant::whereIn('product_id',$id);
       $variant_id=$variantss->pluck('id')->toArray();
       $variant=$variantss->get();
      $quantity=QuantityOfProduct::whereIn('product_id',$id)->get();
       //product details parts
       //$details=Product_details::whereIn('product_variant_id',$variant_id)->get();
       $details=Product_details::whereIn('product_variant_id',$variant_id)->get();
       $variant_details=Variants::where('category_id',$product->category_id);
        $id_s=$variant_details->pluck('id')->toArray();
        $variant_com=$variant_details->get();
       $value=Variant_Value::whereIn('variant_id',$id_s)->get();
      // echo "<pre>";
      // print_r($details->toArray());
      // echo "</pre>";
      // exit();
      //$product=Product::find($request['id']);
      
      //dd($variant->all());
      //$value=Variant_Value::all();
     return view('product_details.edit',compact('product','allbrand','allcategory','variant','details','detail_value','quantity','value','variant_com'));           

      }

    //here adding new variant in edit page so we have to give all options   
    public function adding_new_variants(Request $request){
      // dd($request['id']);
      $product=Product::find($request['id']);

        $variants=Variants::where('category_id',$product->category_id);
        $variant=$variants->get();
        $variant_id=$variants->pluck('id')->toArray();
        //$value_id=Variant_Value::whereIn('variant_id',$variant->id)->get();
        //$variant=Variants::whereIn('id',$value_id->variant_id)->get();
        //dd($variant->all());
        $value=Variant_Value::whereIn('variant_id',$variant_id)->get();
        return view('product_details.new_add_variants',compact('variant','value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
   //storing new variant data in database 
    public function storing_adding_new_variants(Request $request){
           $add=[];

           //finding filled min and max price from filled field
          
          // echo $min;
          // echo $max;
          // exit();
           //dd($pro->price);
         //taking in two variable
          //  echo "<pre>";
          //  print_r($request->toArray());
          //  echo "</pre>";exit;
          
           foreach ($request['add']['price'] as $key => $value) {
               
        $add_img=[];
        if(!empty($request['add']["image"][$key])){
            $add_img=$this->variant_image_store($add_img,$request['add']['image'][$key]);
              }

//  echo "<pre>";
//            print_r($request['add']['variant'][$key][1]);
//            echo "</pre>";exit;
$arr_tempy=[];
foreach ($request['add']['variant'][$key] as $kety => $value) {
 foreach ($value as $keyy => $val) {
  if($val!=null){
   array_push($arr_tempy,$val);
  }
 }
}
              $add=implode("-",array_filter($arr_tempy));
           
           $p=Product_variant::create([
            'product_id'=> $request['id'],
            'combination'=>$add,
            'stock_keeping_unit'=>$request['add']['sku'][$key],
            'price'=>$request['add']['price'][$key],
             'image'=>serialize($add_img)
        ]);
         

      app('App\Http\Controllers\QuantityOfProductController')->quantityStore($request['add']['quantity'][$key],0,$request['id'],$p->id);

            //finding min and max price if that occurs
          
        //filling product details table
        // $product_id_for_details=$p->product_id;
        // $arr_pro_id=[];
        //array_push($arr_new, $product_id_for_details);
        $arr_new=[];
        array_push($arr_new, $p->id);
        $this->product_details_field($request['add']['variant'][$key],$arr_new);
        array_pop($arr_new);

           }
            $pro=Product_variant::where('product_id',$request['id'])->get();
          $product=Product::find($request['id']);
           $min = $pro->pluck('price')->min();
           $max = $pro->pluck('price')->max();
           //updating min and max price
           $product->min_price=$min;
           $product->max_price=$max;
           $product->save();
           $product_id=[];
           array_push($product_id, $request['id']);
           $this->get_min_max($product_id);

    }
public function get_min_max(Array $product_id){
    $pro=Product_variant::where('product_id',$product_id[0])->get();
          $product=Product::find($product_id[0]);
           $min = $pro->pluck('price')->min();
           $max = $pro->pluck('price')->max();
           //updating min and max price
           $product->min_price=$min;
           $product->max_price=$max;
           $product->save();
}
    //update old details 
    public function update(ProductUpdateValidation $request)
    {  
//dd($request->all());
//ProductUpdateValidation
// if($request['add']==null){
//   dd("null");
// }
// if($request['add']!=null){
//   dd("not null");

// }
if(count($request->com)>1){
foreach ($request->com as $key => $value) {
  if($value==null){
    return redirect()->back()->withErrors(['abc'=>'Please choose variant value by option.']);
  }
}}
// dd($request['add']);
      $note=0;
//dd($request->all());
//          echo "<pre>";
//            print_r($request);
//            echo "</pre>";exit;
        $id=$request['id'];
  $validatoin=1;
        $product=Product::find($id);
        if(empty($product)){
          return redirect()->back()->withErrors(['abc'=>'Product not found.']);
        }
      
        $product->product_name=$request['name'];
        $product->product_description=$request['details'];
         $arr=unserialize($product->image);
        if(!empty($request['picture'])){
          $arr=$this->image_store($arr,$request);
        $product->image=serialize($arr);
       }
       
        $product->brand_id=$request['brand'];
        $product->category_id=$request['category'];
       
        $product->save();

      //updating variant part
        $variant=Product_Variant::where('product_id',$id)->get();
       //dd($variant);
        if($request['sku']){
        foreach ($variant as $key => $val) {
        
         $var_arr=unserialize($val->image);

        if(!empty($request['variant_image'][$val->id])){
        $var_arr=$this->variant_image_store($var_arr,$request['variant_image'][$val->id]);
        $val->image=serialize($var_arr);
        }  
       //dd($request['add']['sku']);
        $val->price=$request['price'][$val->id];
        $val->stock_keeping_unit=$request['sku'][$val->id];
       
        //updating min and max price
        $p=Product::find($id);
           //dd($request->all());
            $p->min_price=min($request['price']);
        
       
            $p->max_price=max($request['price']);
        
        $p->save();
         //this to storing a combination of variant  
         $com=[];
           $order=Orders::where('product_variant_id',$val->id)->get();
           if(count($order)==0){
        $details=Product_details::where('product_variant_id',$val->id)->forceDelete();
        //dd($request->all());
         if(isset($request['value'][$val->id])){
       
            $arr_tempy=[];

              foreach(array_filter($request['value'][$val->id]) as $keyee=>$valueyy){
               foreach ($valueyy as $kk => $vval) {
              //    //dd($vval);
             // foreach ($vval as $keyg => $valueg) {
                array_push($arr_tempy,$vval);      
              //}
              
               
          
               }
  
               }
               
       $com=implode("-",array_filter($arr_tempy));
       //dd($com);       
       $val->combination=$com;
       $arr_new=[];
       array_push($arr_new, $val->id);
       $this->product_details_field($request['value'][$val->id],$arr_new);
       array_pop($arr_new);
     }
    }else{
      $note=1;
      session()->flash('notif','Not allow to variant change Because its product order.so you have to re-enter variant clicking by new Add button.');
    }

      $quantity=QuantityOfProduct::where([
      ['product_id','=',$val->product_id],
      ['product_variant_id','=',$val->id],
      ])->latest()->first();

      //dd($request['quantity'][$val->id]);


      if($quantity && $quantity->quantity!=$request['quantity'][$val->id]){
     
      app('App\Http\Controllers\QuantityOfProductController')->quantityStore($request['quantity'][$val->id],0,$val->product_id,$val->id);
     // QuantityOfProduct::create([
     //    'quantity'=>$request['quantity'][$val->id],
     //    'order_id'=>0,
     //    'product_id'=>$val->product_id,
     //    'product_variant_id'=>$val->id
     //       ]);
     }

     
     
       $val->save();
       }

     }
       if(!empty($request['add'])){
             
            $this->storing_adding_new_variants($request);
             

        }
        if($note==0){
        session()->flash('notif','Successfully save product.');
        }
        return redirect()->route('get:ProductController:show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    //variant delete of individual product
    public function delete_variant(){
        $id=$_POST['id'];
       
        $delete=Product_Variant::find($id);
        $details=Product_details::where('product_variant_id',$id)->delete();
        $quantity=QuantityOfProduct::where('product_variant_id',$id)->delete();
        if(!empty($delete)){
        $delete->delete();}
        $p=[];
        array_push($p,$delete->product_id);
        $this->get_min_max($p);
        session()->flash('notif','Successfully variant deleted.');
        return redirect()->back();
    }
    //delete the product with all part(variant and details)
    public function destroy(Request $request)
    {
        $id=$request['id'];
        //find first id which you wants to delete
        $del=Product::where('id',$id)->first();
        $variant=Product_Variant::where('product_id',$id)->get();
        if(count($variant)!=0){
        foreach ($variant as $key => $value) {
            $details=Product_details::where('product_variant_id',$value->id)->delete();
          $quantity=QuantityOfProduct::where('product_variant_id',$value->id)->delete();
          $value->delete();
        }}
        if(!empty($del)){
            $del->delete();
            session()->flash('notif','Successfully product deleted.');
            return redirect()->route('get:ProductController:show');
        }else{
          session()->flash('notif','Product not deleted.');
            return redirect()->route('get:ProductController:show');
        }

    }



    //showing all deleted data 
    public function DeletedDataShow(){
      
        //product id of all deleted variant 
        $product_id=Product_Variant::onlyTrashed()->pluck('product_id')->unique()->toArray();

     //only deleted data
       $variant=Product_Variant::onlyTrashed()->get();

       //product information delete and not deleted details 
       //non deleted product information because let say some //variant are deleted and some variant are not deleted 
   //to showing all details of deleted product 
    $product=Product::withTrashed()->whereIn('id',$product_id)->get();
    
       

            //$details=Product_details::onlyTrashed()->get();
         // $quantity=QuantityOfProduct::onlyTrashed()->get();
          
        return view('product_details.deletedProduct',compact('product','variant'));
      


    }
    //restoring details about product
    public function DeletedDataStore(Request $request){
    
     
     $id=$request['id'];
     //restoring product part
        $product=Product::where('id',$id)->restore();

//to check any variant going to restore or not
        if(count($request['variant_id'])!=0){
//restoring variant data
          $variant=Product_variant::whereIn('id',$request['variant_id'])->restore();

          $details=Product_details::whereIn('product_variant_id',$request['variant_id'])->restore();

    $quantity=QuantityOfProduct::whereIn('product_variant_id',$request['variant_id'])->restore();
          
        }
        session()->flash('notif','Product Restored.');
        return redirect()->route('get:ProductController:show');
    }
}
