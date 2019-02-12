<?php

namespace App\Http\Controllers;

use App\ProductOffer;
use Illuminate\Http\Request;
use App\Product;
use Carbon\Carbon;
use App\Http\Requests\ProductOfferValidation;
class ProductOfferController extends Controller
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
    //here we create offer form
    public function create()
    {

        
        $product=Product::all();
        return view('product_offer.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //storing offer details
    public function store(ProductOfferValidation $request)
    {
           
        //checking product valid or not
        $product=Product::find($request['choose_product_name']);
        //not valid product
        if(empty($product)){
            return redirect()->back()->withErrors(['abc'=>'Please Choose Valid Product']);
        }
       //converting correct format to use in storages
        $start_validity=Carbon::createFromFormat('d/m/Y h:i A',$request['from']." ".$request['from_t'])->format('Y-m-d H:i:s');
      
        $end_validity=Carbon::createFromFormat('d/m/Y h:i A',$request['to']." ".$request['to_t'])->format('Y-m-d H:i:s');
        //if product offer date invaild data like starting date is greater then ending date 
        if(Carbon::parse($start_validity)->gte($end_validity)){
           return redirect('/product_offer')->withErrors(['ab'=>'Please Enter valid date.']); 
        }
        //creating a object to compare if offer already available on the product 
        $offer=ProductOffer::where('product_id',$product->id)->get();
        //if product are on offer for this date so its give error
        if(isset($offer)){
            //to checked individual date of a product
            foreach ($offer as $off) {
         $store_starting_date=Carbon::parse($off->validity_From)->format('Y-m-d H:i:s');
        $store_ending_date=Carbon::parse($off->validity_To)->format('Y-m-d H:i:s');
        
        //checking algo like stored starting date is less then end date of entering  current offer
        //and store ending date is greater then starting date of current offer   
        if(Carbon::parse($store_starting_date)->lte($end_validity) && Carbon::parse($store_ending_date)->gte($start_validity)){
            

           //redirecting with error
            return redirect('/product_offer')->withErrors(['abc'=>'Validity Overlaps. Please Choose Another Date Range']);
        } 
            }
        }
   
        ProductOffer::create([
        'product_id'=>$product->id,
        'type'=>$request['type'],
        'offer_amount'=>$request['amount'],
        'validity_From'=>$start_validity,
        'validity_To'=>$end_validity
         ]);
         
         if(isset($_POST['save']))
         { session()->flash('notif','product offer data stored.');
       return redirect()->route('get:ProductOfferController:show');}
       else{
        session()->flash('notif','product offer data stored.');
         return redirect()->route('get:ProductOfferController:create');
    }
     

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductOffer  $productOffer
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOffer $productOffer)
    {
        $offer=ProductOffer::with('product')->get();

         return view('product_offer.show',compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductOffer  $productOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductOffer $productOffer)
    {
        
        $offer=ProductOffer::where('id',$_GET['id'])->with('product')->first();
        $allproduct=Product::where('id','!=',$offer->product_id)->get();
        return view('product_offer.edit',compact('offer','allproduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductOffer  $productOffer
     * @return \Illuminate\Http\Response
     */
    public function update(ProductOfferValidation $request)
    {

//checking product valid or not
$product=Product::find($request['choose_product_name']);
//not vaild product
        if(empty($product)){
            return redirect()->back()->withErrors(['abc'=>'Please Choose Valid Product']);
        }
        //converting correct format to use in storages
         $start_validity=Carbon::createFromFormat('d/m/Y h:i A',$request["from"]." ".$request["from_t"])->format('Y-m-d H:i:s');
        $end_validity=Carbon::createFromFormat('d/m/Y h:i A',$request["to"]." ".$request["to_t"])->format('Y-m-d H:i:s');
        //if product offer date invaild data like starting date is greater then ending date 
        if(Carbon::parse($start_validity)->gte($end_validity)){
           return redirect()->back()->withErrors(['ab'=>'Please Enter valid date.']); 
        }
        //creating a object to compare if offer already available on the product  
        $offer=ProductOffer::where('id','!=',$request['id'])->where('product_id',$product->id)->get();
        //if product are on offer for this date so its give error
        if(isset($offer)){
        //to checked individual date of a product
        foreach($offer as $off){
         $store_starting_date=Carbon::parse($off->validity_From)->format('Y-m-d H:i:s');
        $store_ending_date=Carbon::parse($off->validity_To)->format('Y-m-d H:i:s');
         //checking algo like stored starting date is less then end date of entering  current offer
        //and store ending date is greater then starting date of current offer 
        if(Carbon::parse($store_starting_date)->lte($end_validity) && Carbon::parse($store_ending_date)->gte($start_validity)){
            

           
            return redirect()->back()->withErrors(['abc'=>'Validity Overlaps. Please Choose Another Date Range']);
        }
        
        

     }
     }
     
         $id=$_POST['id'];
        $offer=ProductOffer::find($id);
        $offer->product_id=$product->id;
        $offer->type=$request['type'];
        $offer->offer_amount=$request['amount'];
        $offer->validity_From=$start_validity;
        $offer->validity_To=$end_validity;
        $offer->save();
        session()->flash('notif','product offer data updated.');
        return redirect()->route('get:ProductOfferController:show');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductOffer  $productOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductOffer $productOffer)
    {
         $id=$_POST['delete'];
      //dd($id);
       $del=ProductOffer::where('id',$id)->first();
       if(!empty($del)){
        $del->delete();
        //session()->flash('notif','product offer data deleted.');
        return redirect()->route('get:ProductOfferController:show');
       }else{
        //session()->flash('notif','product offer data not deleted.');
        return redirect()->route('get:ProductOfferController:show');
       }
    }
//show all soft deleted data
    public function DeletedDataShow(Request $request){
          $offer=ProductOffer::onlyTrashed()->get();
        return view('product_offer.Deleted_data',compact('offer'));
    }
    //restoring deleted item
    public function DeletedDataStore(Request $request){

        $id=$request['id'];
        $offer=ProductOffer::where('id',$id)->restore();
        session()->flash('notif','product offer data Restored.');
        return redirect()->back();
    }
    //permanently detele
    public function DeletedDataPermanentlyDelete(Request $request){
        
         $id=$request['id'];
        $offer=ProductOffer::where('id',$id)->forceDelete();
        session()->flash('notif','product offer data permanently deteled.');
        return redirect()->back();
    }
}
