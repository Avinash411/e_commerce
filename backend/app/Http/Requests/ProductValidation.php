<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use App\Http\Requests\Request;

use Illuminate\Http\Request;

class ProductValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    { 
     //dd($request['product_type']);
     if($request['product_type']=="simple"){
        return [
            'name'=>'required|max:255',
            'details'=>'required',
            
            'brand'=>'required',
            'category'=>'required',
            'rate'=>'required',
          'sku'=>'required|unique:product_variants,stock_keeping_unit'
        ];
     }
     else{
        return [
           'name'=>'required|max:255',
            'details'=>'required',
            
            'brand'=>'required',
            'category'=>'required',
           
            'gg.*.price'=>'required',
            'gg.*.sku'=>'required|unique:product_variants,stock_keeping_unit'
            
        ];
     }
        
    }
}
