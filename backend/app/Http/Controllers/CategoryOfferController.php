<?php

namespace App\Http\Controllers;

use App\CategoryOffer;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryOfferValidation;
use App\ProductCategory;
use Carbon\Carbon;
use Validator;
class CategoryOfferController extends Controller
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
    //offer page to enter data
    public function create()
    {
        $category=ProductCategory::all();
        return view('category_offer.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //storing offer data 
    public function store(CategoryOfferValidation $request)
    {

//checking category valid or not
        $category=ProductCategory::find($request['choose_category']);
        //if not valid
        if(empty($category)){
            return redirect()->back()->withErrors(['abc'=>'Please Choose Valid Category']);
        }
        //making correct format of the dates
        $start_validity=Carbon::createFromFormat('d/m/Y h:i A',$request["from"]." ".$request["from_t"])->format('Y-m-d H:i:s');
        $end_validity=Carbon::createFromFormat('d/m/Y h:i A',$request["to"]." ".$request["to_t"])->format('Y-m-d H:i:s');
        //checked valid enter date
        if(Carbon::parse($start_validity)->gte($end_validity)){
           return redirect('/category_offer')->withErrors(['ab'=>'Please Enter valid date.']); 
        }
        //creating object of current cotegory 
        $offer=CategoryOffer::where('category_id',$category->id)->get();
        //if category already available 
        if(isset($offer)){
        //checking individual date 
        foreach($offer as $off){
         $store_starting_date=Carbon::parse($off->validity_From)->format('Y-m-d H:i:s');
        $store_ending_date=Carbon::parse($off->validity_To)->format('Y-m-d H:i:s');
        
        //its checking date is not crossing each other like valid date 
        if(Carbon::parse($store_starting_date)->lte($end_validity) && Carbon::parse($store_ending_date)->gte($start_validity)){
            

           
            return redirect('/category_offer')->withErrors(['abc'=>'Validity Overlaps. Please Choose Another Date Range']);
        } 
        

     }
}


         CategoryOffer::create([
        'category_id'=>$category->id,
        'type'=>$request['type'],
        'offer_amount'=>$request['amount'],
        'validity_From'=>$start_validity,
        'validity_To'=>$end_validity
         ]);
         
         if(isset($_POST['save']))
         { 
            session()->flash('notif','category offer data stored.');
       return redirect()->route('get:CategoryOfferController:show');}
       else{
        session()->flash('notif','category offer data stored.');
         return redirect()->route('get:BrandController:create');
    } 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CategoryOffer  $categoryOffer
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryOffer $categoryOffer)
    {
         $offer=CategoryOffer::with('Category')->get();

         return view('category_offer.show',compact('offer'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CategoryOffer  $categoryOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryOffer $categoryOffer)
    {
        $offer=CategoryOffer::where('id',$_GET['id'])->with('Category')->first();
        $allcategory=ProductCategory::where('id','!=',$offer->category_id)->get();
        return view('category_offer.edit',compact('offer','allcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CategoryOffer  $categoryOffer
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryOfferValidation $request)
    {
//checking category valid or not
 $category=ProductCategory::find($request['choose_category']);

 //not valid category
        if(empty($category)){
            return redirect()->back()->withErrors(['abc'=>'Please Choose Valid Category']);
        }
         //making correct format of the dates
        $start_validity=Carbon::createFromFormat('d/m/Y h:i A',$request["from"]." ".$request["from_t"])->format('Y-m-d H:i:s');
        $end_validity=Carbon::createFromFormat('d/m/Y h:i A',$request["to"]." ".$request["to_t"])->format('Y-m-d H:i:s');
         //checked valid enter date
        if(Carbon::parse($start_validity)->gte($end_validity)){
           return redirect()->back()->withErrors(['ab'=>'Please Enter valid date.']); 
        }
         //creating object of current cotegory 
        $offer=CategoryOffer::where('id','!=',$request['id'])->where('category_id',$category->id)->get();
        //checking for specific category is availble if the check individual date is not crosssing
        
        if(isset($offer)){
   
        foreach($offer as $off){
         $store_starting_date=Carbon::parse($off->validity_From)->format('Y-m-d H:i:s');
        $store_ending_date=Carbon::parse($off->validity_To)->format('Y-m-d H:i:s');
        
        if(Carbon::parse($store_starting_date)->lte($end_validity) && Carbon::parse($store_ending_date)->gte($start_validity)){
            

           
            return redirect()->back()->withErrors(['abc'=>'Validity Overlaps. Please Choose Another Date Range']);
        }
       
        

     }
     }
     
         $id=$_POST['id'];
        $offer=CategoryOffer::find($id);
        $offer->category_id=$category->id;
        $offer->type=$request['type'];
        $offer->offer_amount=$request['amount'];
        $offer->validity_From=$start_validity;
        $offer->validity_To=$end_validity;
        $offer->save();
        session()->flash('notif','category offer data updated.');
        return redirect('/category_offer/show');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CategoryOffer  $categoryOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {


        
         $id=$_POST['delete'];
     // dd($id);
       $del=CategoryOffer::where('id',$id)->first();
       if(!empty($del)){
        $del->delete();
        session()->flash('notif','category offer data deleted.');
        return redirect()->route('get:CategoryOfferController:show');
       }else{
        session()->flash('notif','category offer data not deleted.');
        return redirect()->route('get:CategoryOfferController:show');
       }
    }

    //show all soft deleted data
    public function DeletedDataShow(Request $request){
        //dd("hii");
          $offer=CategoryOffer::onlyTrashed()->get();
        return view('category_offer.Deleted_data',compact('offer'));
    }
    //restoring deleted item
    public function DeletedDataStore(Request $request){

        $id=$request['id'];
        $offer=CategoryOffer::where('id',$id)->restore();
        session()->flash('notif','category offer data Restored.');
        return redirect()->back();
    }
    //permanently detele
    public function DeletedDataPermanentlyDelete(Request $request){
        
         $id=$request['id'];
        $offer=CategoryOffer::where('id',$id)->forceDelete();
        session()->flash('notif','category offer data permanently deleted.');
        return redirect()->back();
    }
}
