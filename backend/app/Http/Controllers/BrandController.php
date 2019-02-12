<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\ProductCategory;
use App\Http\Requests\BrandValidation;
use App\Brand;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

       $category=(new ProductCategory)::all();
        
        return view('brands_details.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandValidation $request)
    {
        
// echo $request;
// exit();
        //dd($request->all());
        foreach ($request['category'] as $key => $value) {
          //checking category exist  
        $category=ProductCategory::find($value);
        if(empty($category)){
      return redirect()->back()->withErrors(['abc'=>'Please Choose Valid  Caterory']);
  
    }

// checking Brand Name and Refer Caterory must be unique    
    $combination=Brand::where([
    ['brand_name','=',$request['name']],
    ['category_id','=',$category->id]
    ])->get();
    if(count($combination)>0){
         return redirect()->back()->withErrors(['abc'=>'Brand Name and Refer Caterory must be unique.This combination already exist.']);
    }    





    Brand::create([
        'brand_name'=>$request['name'],
        'brand_description'=>$request['details'],
        'category_id'=>$category->id
        ]);
        }
       


    

    //dd("jdhsajd");
            //dd(2);
        
        if(isset($_POST['save']))
         { 
            session()->flash('notif','Brand stored.');
       return redirect()->route('get:BrandController:show');}
       else{
        session()->flash('notif','Brand stored.');
         return redirect()->route('get:BrandController:create');
    } 



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        $brand=Brand::all()->groupBy('brand_name');
        //dd($brand->all());
        // echo "<pre>";
        // print_r($brand);
        // echo "</pre>";
        // exit();
        return view('brands_details.show',compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        //dd($id);
      $brand=Brand::where('id',$id)->first();

      if(empty($brand)){
      return redirect()->back()->withErrors(['abc'=>'Edit not find.']);
  
    }

      $brand_categories =  Brand::where('brand_name',$brand->brand_name)->pluck('category_id')->toArray();

      //dd($brand_categories); 

      $allcategory=ProductCategory::all();
      return view('brands_details.edit',compact('brand','allcategory','brand_categories'));           
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */


   
    //updating brand part
    public function update(Request $request)
    {
        


//varify category Id
$category=ProductCategory::whereIn('id',$request['category'])->get();
        if(count($category)==0){
      return redirect()->back()->withErrors(['abc'=>'Please Choose Valid  Caterory']);
  
    }


$id=$request['id'];
//finding a existing brand name
$exist_brand=Brand::find($id);


//all information of particular brand 
$exist_AllBrand=Brand::where('brand_name',$exist_brand->brand_name)->get();



//taking all brand id
$exist_brandId=$exist_AllBrand->pluck('id')->toArray();

//taking all category id that is exist in a particuler brand
$exist_category=$exist_AllBrand->pluck('category_id')->toArray();
//taking all category id for update
$new_category=$category->pluck('id')->toArray();

//get id of new add category
$addedId=array_diff($new_category,$exist_category);
$arr=[];
if(count($addedId)){
    foreach ($addedId as $key => $value) {
//checking any combination are exist or not
    $combination=Brand::where([
    ['brand_name','=',$request['name']],
    ['category_id','=',$value]
    ])->whereNotIn('id',$exist_brandId)->get();

   if(count($combination)>0){
         return redirect()->back()->withErrors(['abc'=>'Brand Name and Refer Caterory must be unique.This combination already exist.']);
    }   




//creating new brand by updating
         $createId=Brand::create([
        'brand_name'=>$request['name'],
        'brand_description'=>$request['details'],
        'category_id'=>$value
        ]);

         //taking all id that is new inserted so
         //for ignore that in updating name process
         //it create new so its exist in data base and for that ,in last of update function am updating the name of brand name so brfore update this for checking if this already exist are not so for now new add brand name exist then we have to ignore this for now 
         array_push($arr, $createId->id);
    }
}

//taking all category id for remove
$removeId=array_diff($exist_category, $new_category);
//removing category id
if(count($removeId)!=0){
$remove=Brand::whereIn('id',$exist_brandId)->whereIn('category_id',$removeId)->forceDelete();
}


//if name is not same 
if($exist_brand->brand_name!=$request['name']){

//$exist_brand->brand_name =$request['name'];
$forname=Brand::whereNotIn('id',$arr)->where('brand_name',$request['name'])->pluck('id')->toArray();


if(count($forname)){

     return redirect()->back()->withErrors(['abc'=>'Brand Name must be unique.']);
}

    $update=Brand::whereIn('id',$exist_brandId)->update(['brand_name' => $request['name']]);
   

    }
         //redirect page
         session()->flash('notif','Brand updated.');
         return redirect()->route('get:BrandController:show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    //softdelete process
    public function destroy(Request $request)
    {

       
        $id=$request['delete'];
       

//dd($id);
//finding a existing brand name
$exist_brand=Brand::find($id);

//dd($exist_brand);
//all information of particular brand 
$exist_AllBrand=Brand::where('brand_name',$exist_brand->brand_name)->get();



//taking all brand id
$exist_brandId=$exist_AllBrand->pluck('id')->toArray();
//dd("hii");


 $del=Brand::whereIn('id',$exist_brandId)->delete();
 
       if(!empty($del)){
        session()->flash('notif','Brand deleted.');
        return redirect()->route('get:BrandController:show');
       }else{
        session()->flash('notif','Brand not deleted.');
        return redirect()->route('get:BrandController:show');
       }
    }
    //showing all deleted item 
    public function DeletedDataShow(){

        $brand=Brand::onlyTrashed()->get()->groupBy('brand_name');
        
return view('brands_details.Deleted_data',compact('brand'));
    }
    //restoring deleted item
    public function DeletedDataStore(Request $request){
        $id=$request['id'];

        $exist_brand=Brand::withTrashed()->find($id);
        
        $exist_AllBrand=Brand::withTrashed()->where('brand_name',$exist_brand->brand_name)->restore();

       

// //taking all brand id

session()->flash('notif','Brand Restored.');
       
        return redirect()->route('get:BrandController:DeletedDataShow');
    }
}
