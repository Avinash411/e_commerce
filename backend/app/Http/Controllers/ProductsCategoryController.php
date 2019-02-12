<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
 use App\Http\Requests\CategoryValidation;

class ProductsCategoryController extends Controller
{
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
        $cat=ProductCategory::all();
        return view('product_category.create',compact('cat'));
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryValidation $request)
    {   

  //checking parent category unique or not     
if($request['category']!=0){
$category=ProductCategory::find($request['category']);    
    if(empty($category)){
      return redirect()->back()->withErrors(['abc'=>'Please Choose Valid Parent Caterory']);
  
    }}
    //not same as parent name
    
//dd($temp);
    //dd("hy");
         ProductCategory::create([
          'category_name'=>$request['name'],
          'parent_category'=>$request['category']
        ]);
         if(isset($_POST['save']))
         {
            session()->flash('notif','category data stored.');
         return redirect()->route('get:ProductsCategoryController:show');

        }else{
            session()->flash('notif','category data stored.');
            return redirect()->route('get:ProductsCategoryController:create');
     
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products_Category  $products_Category
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {         
  
        $productCategory=ProductCategory::all();
        
    
        return view('product_category.show',compact('productCategory'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products_Category  $products_Category
     * @return \Illuminate\Http\Response
     */
//edit old deatls
 public function edit($id)
 {

   // dd($id);
    //find which category you want to edit          
     $product=ProductCategory::where('id',$id)->first();
     if(empty($product)){
          return redirect()->back()->withErrors(['abc'=>'Edit not find.']);
     }
             $allcategory=ProductCategory::all();
        return view('product_category.edit',compact('product','allcategory')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    //store old details in datebase
    public function update(CategoryValidation $request)
    {   
    


       //first taking id that was posted by edit form    
        $id=$request['id'];
        //finding details by id
        $product = ProductCategory::find($id);
        if(empty($product)){
          return redirect()->back()->withErrors(['abc'=>'Update not find.']);
     }
        //update by re-enter value
        $product->category_name =$request['name'];
        $product->parent_category =$request['category'];

        //save upadate date in database
        $product->save();
         //redirect page
         session()->flash('notif','category data updated.');
         return redirect()->route('get:ProductsCategoryController:show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $id=$request['id'];
      
       $del=ProductCategory::where('id',$id)->first();
       if(!empty($del)){
        $del->delete();
        //session()->flash('notif','category data deteled.');
        return redirect()->route('get:ProductsCategoryController:show');
       }else{
        //session()->flash('notif','category data not deleted.');
        return redirect()->route('get:ProductsCategoryController:show');
       }
       
       

}
//showing all deleted data
public function DeletedDataShow(){
     $productCategory=ProductCategory::onlyTrashed()->get();
     $parentCategory=ProductCategory::all();
   //dd($productCategory);
        return view('product_category.DeletedShow',compact('productCategory','parentCategory'));
}
//restoring data
public function DeletedDataStore(Request $request){
    $id=$request['id'];
      
       $del=ProductCategory::where('id',$id)->restore();
       session()->flash('notif','category data Restored.');
      return redirect()->route('get:ProductsCategoryController:DeletedDataShow');
}


// public function getUniqueCategory(){
//     if($request['category']!=0){
// $category=ProductCategory::find($request['category']);    
//     if(empty($category)){
//       return redirect()->back()->withErrors(['abc'=>'Please Choose Valid Parent Caterory']);
  
//     }
//     //not same as parent name
// if($category->category_name==$request['name']){
//     return redirect()->back()->withErrors(['abc'=>'Please Enter Unique Category Name']);
// }
// //all child of particuler parent should be unquie.
//     //checking all child here
// //dd($request['category']);
// $childcheck=ProductCategory::where('parent_category',$request['category'])->get();
// //dd($childcheck);
// if(!empty($childcheck)){

// foreach ($childcheck as $key => $value) {
//    if($request['name']==$value['category_name']){
//     return redirect()->back()->withErrors(['abc'=>'Please Enter Unique Category Name']);
//    }
// }

// }



// $temp=$category->parent_category;

// while ( $temp>0) {
       
//      $tempCategory=ProductCategory::where('id',$temp)->get();

//      if(count($tempCategory)==0){
//     $temp=0;
// }
//      foreach ($tempCategory as $key => $parentvalue) {
//     if($request['name']==$parentvalue['category_name']){
//     return redirect()->back()->withErrors(['abc'=>'Please Enter Unique Category Name']);
//    }else{
//          $temp=$parentvalue['parent_category'];
//    }

//      }




//  }


//     }


// }
}
