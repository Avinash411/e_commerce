<?php

namespace App\Http\Controllers;

use App\Variant_Value;
use Illuminate\Http\Request;
use App\Http\Requests\VariantValueValidation;
use App\ProductCategory;
use App\Variants;
use DB;
class VariantValueController extends Controller
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

       // $variant=Variants::all();
        return view('variant_value.create',compact('category'));
    }
//get all variant name for option on a particuler catergory
public function allVariantOfCategory(Request $request){
//dd($request);
    $category=ProductCategory::find($request['id']);
    if(empty($category)){
         return redirect()->back()->withErrors(['abc'=>'Please Choose Valid  Category']);
    }
  $variant=Variants::where('category_id',$category->id)->get();
  //dd($variant);
return view('variant_value.variantOfCategory',compact('variant'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariantValueValidation $request)
    { 

//dd($request->all());
$variant=Variants::find($request['variant']);
        if(empty($variant)){
          return redirect()->back()->withErrors(['abc'=>'Please Choose Valid  Variant']);
  
        }

foreach (array_filter($request['name']) as $key => $value) {
         Variant_Value::create([
         'variant_id'=>$variant->id,
         'variant_value'=>$value
        ]);
     }     
       
        if(isset($_POST['save'])){
            session()->flash('notif','variant value data stored.');
            return redirect()->route('get:VariantValueController:show');
        }
        else{
            session()->flash('notif','variant value data stored.');
            return redirect()->route('get:VariantValueController:create');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Variant_Value  $variant_Value
     * @return \Illuminate\Http\Response
     */
    public function show(Variant_Value $variant_Value)
    {


$shares = DB::table('variant__values')
    ->join('variants', 'variants.id', '=', 'variant__values.variant_id')
    ->join('product_categories', 'product_categories.id', '=', 'variants.category_id')->where('variant__values.deleted_at','=',NULL)->get();
   
    $data = $shares->groupBy('category_name');

    $total_data = $data->toArray();
    
    $cat = [];


    foreach($data as $key => $cat_name)
    { 
        

        $cat[$key] = ($data[$key])->groupBy('variant_name')->toArray();
        $cat[$key]['count'] = count($total_data[$key]);
    }   


        return view('variant_value.show',compact('value','allcategory','data','cat'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variant_Value  $variant_Value
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $arr=explode("&&",$id);

       // dd($arr);
        $category=ProductCategory::where('category_name',$arr[0])->first();
       if(empty($category)){
        return redirect()->back()->withErrors(['abc'=>'Edit not find.']);
  
       }
       //dd($arr[1]);

       $variant=Variants::where([
         ['variant_name',$arr[1]] ,
        ['category_id',$category->id]
        
    ])->get();
       
// dd($variant);
       if(count($variant)==0){
         return redirect()->back()->withErrors(['abc'=>'This variant is deleted.']);
       }
       
        
        $value=Variant_Value::where('variant_id',$variant[0]->id)->get();
       //dd($value->toArray());
        $allvariant=Variants::where('category_id',$category->id)->get();
        $name=[];
      
        foreach ($value as $key => $val) {
          array_push($name, $val->variant_value);
          
        }
        //dd($name);
        $allname=implode(",", $name);
        
        //dd($allname);
       //dd($allvariant->toArray());
        return view('variant_value.edit',compact('value','allvariant','category','allname')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variant_Value  $variant_Value
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

   //dd($request->all()); 
       $id=$request['id'];
        
     $variant=Variants::find($id);

        if(empty($variant)){
          return redirect()->back()->withErrors(['abc'=>'Variant name not exist.']);  
        }

       
        $updateForvariant=Variants::find($request['variant']);

        if(empty($updateForvariant)){
          return redirect()->back()->withErrors(['abc'=>'update Variant name not exist.']);  
        }

$value=Variant_Value::where('variant_id',$id)->get();
if(count($value)==0){
          return redirect()->back()->withErrors(['abc'=>'Variant name not exist.Please Valid Variant name.']);  
}
$exist_id=$value->pluck('id')->toArray();
$exist_name=$value->pluck('variant_value')->toArray();
$exist_variant=$value->pluck('variant_id')->toArray();


$updateForName=array_filter(explode(",",$request['name']));

$addName=array_diff($updateForName,$exist_name);
$arr=[];


if(count($addName)){

       foreach ($addName as $key => $value) {
//checking any combination are exist or not
    $combination=Variant_Value::where([
    ['variant_value','=',$value],
    ['variant_id','=',$updateForvariant->id]
    ])->whereNotIn('id',$exist_id)->get();
//if dublicate available 
   if(count($combination)>0){
         return redirect()->back()->withErrors(['abc'=>'Variant Name and Variant Value must be unique.This combination already exist.']);
    }   




//creating new brand by updating
         $createId=Variant_Value::create([
        'variant_value'=>$value,
        
        'variant_id'=>$updateForvariant->id
        ]);

         //taking all id that is new inserted so
         //for ignore that in updating name process
         //it create new so its exist in data base and for that ,in last of update function am updating the name of brand name so brfore update this for checking if this already exist are not so for now new add brand name exist then we have to ignore this for now 
         array_push($arr, $createId->id);
    }




    }

$removeName=array_diff($exist_name,$updateForName);

if(count($removeName)!=0){
$remove=Variant_Value::whereIn('id',$exist_id)->whereIn('variant_value',$removeName)->forceDelete();
}




if(reset($exist_variant)!=$updateForvariant->id){


$forname=Variant_Value::whereNotIn('id',$arr)->where('variant_id',$updateForvariant->id)->pluck('id')->toArray();


if(count($forname)){

     return redirect()->back()->withErrors(['abc'=>'Variant Name must be unique.']);
}

    $update=Variant_Value::whereIn('id',$exist_id)->update(['variant_id' => $updateForvariant->id]);
   

    }

    session()->flash('notif','variant value data stored.');
        return redirect()->route('get:VariantValueController:show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variant_Value  $variant_Value
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
             $arr=explode("&&",$request['delete']);

        $category=ProductCategory::where('category_name',$arr[0])->first();
        //dd($category);
       if(empty($category)){
        return redirect()->back()->withErrors(['abc'=>'Category not found.']);
  
       }

//dd($variant);
$variant=Variants::where([
    ['variant_name','=',$arr[1]],
    ['category_id','=',$category->id]
    ])->withTrashed()->first();
//dd($variant);
//if(emp$variant)
        //dd($request->all());
       // $del=$request['delete'];
             $delete=Variant_Value::where('variant_id',$variant->id)->delete();
       // $value=Variant_Value::find($del);
        //$value->delete();
if(!empty($delete)){
      return redirect()->route('get:VariantValueController:show');
}
else{
    return redirect()->route('get:VariantValueController:show');
}


        
    }
    //showing all deleted item
    public function DeleteData(){

//dd("k");
$shares = DB::table('variant__values')
    ->join('variants', 'variants.id', '=', 'variant__values.variant_id')
    ->join('product_categories', 'product_categories.id', '=', 'variants.category_id')->where('variant__values.deleted_at','!=',NULL)->get();
//dd("k");   
    $data = $shares->groupBy('category_name');

    $total_data = $data->toArray();
    
    $cat = [];


    foreach($data as $key => $cat_name)
    { 
        

        $cat[$key] = ($data[$key])->groupBy('variant_name')->toArray();
        $cat[$key]['count'] = count($total_data[$key]);
    }   


        //return view('variant_value.show',compact('value','allcategory','data','cat'));




       // $value=Variant_Value::with('variants')->onlyTrashed()->get();
        return view('variant_value.DeletedDataShow',compact('value','allcategory','data','cat'));

    }

    //restoring data 
    public function RestoreData(Request $request){
        //dd($request->all());
      
 $category=ProductCategory::where('category_name',$request['category'])->first();
       if(empty($category)){
        return redirect()->back()->withErrors(['abc'=>'Category not found.']);
  
       }


$variant=Variants::where([
    ['variant_name','=',$request['id']],
    ['category_id','=',$category->id]
    ])->withTrashed()->first();
//if dublicate available 
   
//dd($variant);



      

        $variant=Variant_Value::where('variant_id',$variant->id)->restore();
        return redirect()->route('get:VariantValueController:DeleteData');
    }
}
