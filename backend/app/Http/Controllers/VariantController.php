<?php

namespace App\Http\Controllers;

use App\Variants;
use Illuminate\Http\Request;
use App\Http\Requests\VariantsValidation;
use App\ProductCategory;

class VariantController extends Controller
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
        $category=ProductCategory::all();
        return view('variation.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariantsValidation $request)
    { //
//dd($request->all());
//checking category is valid or not
$category=ProductCategory::find($request['category']);
        if(empty($category)){
      return redirect()->back()->withErrors(['abc'=>'Please Choose Valid  Caterory']);
  
    }
        //insert all new row  
    foreach ($request['name'] as $key => $value) {
        if(!empty($value)){
       Variants::create([
        'variant_name'=>$value,
        'category_id'=>$category->id
        ]);
   }
    }
        
        if(isset($_POST['save']))
         { 
            session()->flash('notif','variant data stored.');
       return redirect()->route('get:VariantController:show');}
       else{
        session()->flash('notif','variant data stored.');
         return redirect()->route('get:VariantController:create');
    } 
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Variants  $variants
     * @return \Illuminate\Http\Response
     */
    public function show(Variants $variants)
    {
        $variant=Variants::all()->groupBy('category_id');
        
     return view('variation.show',compact('variant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variants  $variants
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        
        $variant=Variants::where('category_id',$id)->get();
        
 if(empty($variant)){
      return redirect()->back()->withErrors(['abc'=>'Edit not find.']);
  
    }

        $category=ProductCategory::all();
        return view('variation.edit',compact('variant','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variants  $variants
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $category=ProductCategory::find($request['category']);
        if(empty($category)){
      return redirect()->back()->withErrors(['abc'=>'Please Choose Valid  Caterory']);
  
    }
    $id=$request['id'];
    //getting information about all existing category
    $exist_details=Variants::where('category_id',$id)->get();
    $exist_name=$exist_details->pluck('variant_name')->toArray();
    $exist_id=$exist_details->pluck('id')->toArray();

    $exist_category_id=$exist_details->pluck('category_id')->toArray();
    //name for update
    $updateForName=array_filter(explode(",",$request['name']));
    

    $added_name=array_diff($updateForName, $exist_name);
    $arr=[];
    
    if(count($added_name)){

       foreach ($added_name as $key => $value) {
//checking any combination are exist or not
    $combination=Variants::where([
    ['variant_name','=',$value],
    ['category_id','=',$category->id]
    ])->whereNotIn('id',$exist_id)->get();
//if dublicate available 
   if(count($combination)>0){
         return redirect()->back()->withErrors(['abc'=>'Variant Name and Refer Caterory must be unique.This combination already exist.']);
    }   




//creating new brand by updating
         $createId=Variants::create([
        'variant_name'=>$value,
        
        'category_id'=>$category->id
        ]);

         //taking all id that is new inserted so
         //for ignore that in updating name process
         //it create new so its exist in data base and for that ,in last of update function am updating the name of brand name so brfore update this for checking if this already exist are not so for now new add brand name exist then we have to ignore this for now 
         array_push($arr, $createId->id);
    }




    }



    $removeName=array_diff($exist_name, $updateForName);
//removing Name
if(count($removeName)!=0){
$remove=variants::whereIn('id',$exist_id)->whereIn('variant_name',$removeName)->forceDelete();
}

//if category change
if(reset($exist_category_id)!=$category->id){


$forname=Variants::whereNotIn('id',$arr)->where('category_id',$category->id)->pluck('id')->toArray();


if(count($forname)){

     return redirect()->back()->withErrors(['abc'=>'category Name must be unique.']);
}

    $update=Variants::whereIn('id',$exist_id)->update(['category_id' => $category->id]);
   

    }

    session()->flash('notif','variant data updated.');
        return redirect()->route('get:VariantController:show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variants  $variants
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $del=$request['delete'];
        //deleting by category id
        $variant=Variants::where('category_id',$del)->delete();
       
        if(!empty($variant)){
      //      session()->flash('notif','variant data deleted.');
      return redirect()->route('get:VariantController:show');
}
else{
    //session()->flash('notif','variant data not deleted.');
    return redirect()->route('get:VariantController:show');
}
    }
    //showing all deleted item
    public function DeleteData(){

        
        $variant=Variants::onlyTrashed()->get()->groupBy('category_id');
        return view('variation.DeletedDataShow',compact('variant'));

    }

    //restoring data 
    public function RestoreData(Request $request){
       
//restore by category id
$exist_variant=Variants::withTrashed()->where('category_id',$request['id'])->get();
$variant_id=$exist_variant->pluck('id')->toArray();

        
        $exist_Allvariant=variants::withTrashed()->whereIn('id',$variant_id)->restore();




        return redirect()->route('get:VariantController:DeleteData');
    }
}
