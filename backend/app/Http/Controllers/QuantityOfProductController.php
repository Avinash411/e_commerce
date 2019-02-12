<?php

namespace App\Http\Controllers;

use App\QuantityOfProduct;
use Illuminate\Http\Request;

class QuantityOfProductController extends Controller
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
        //
    }
    public function quantityStore($quantity,$order_id,$product_id,$product_variant_id){
        QuantityOfProduct::create([
        'quantity'=>$quantity,
        'order_id'=>$order_id,
        'product_id'=>$product_id,
        'product_variant_id'=>$product_variant_id
           ]);
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
     * @param  \App\QuantityOfProduct  $quantityOfProduct
     * @return \Illuminate\Http\Response
     */
    public function show(QuantityOfProduct $quantityOfProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuantityOfProduct  $quantityOfProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(QuantityOfProduct $quantityOfProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuantityOfProduct  $quantityOfProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuantityOfProduct $quantityOfProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuantityOfProduct  $quantityOfProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuantityOfProduct $quantityOfProduct)
    {
        //
    }
}
