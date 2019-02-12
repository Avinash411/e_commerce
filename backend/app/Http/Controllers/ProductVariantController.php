<?php

namespace App\Http\Controllers;

use App\Product_variant;
use Illuminate\Http\Request;
use App\Product;
use App\Variants;
use App\Variant_Value;
use App\ProductCategory;
class ProductVariantController extends Controller
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
      // $category=ProductCategory::all();
      // $product=Product::all();
      //   $variant=Variants::all();
      //   $value=Variant_Value::all();
       // return view('product_variant.create',compact('category','product','variant','value'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product_variant  $product_variant
     * @return \Illuminate\Http\Response
     */
    public function show(Product_variant $product_variant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product_variant  $product_variant
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_variant $product_variant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product_variant  $product_variant
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product_variant  $product_variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_variant $product_variant)
    {
        //
    }
}
