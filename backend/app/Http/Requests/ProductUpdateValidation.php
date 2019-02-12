<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class ProductUpdateValidation extends FormRequest
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
        if($request['add']==null){
            return [
                'name'=>'required|max:255',
                'details'=>'required',
                
                'brand'=>'required',
                'category'=>'required',
                'price.*'=>'required',
             // 'sku.*'=>'required|unique:product_variants,stock_keeping_unit.ltrim(sku.*,"sku.")'
            'sku.*'=>'required | unique:product_variants,stock_keeping_unit,*',
            // 'sku.*'=>['required',Rule::unique('product_variants,stock_keeping_unit')->ignore(302)]
            ];
         }
          else{
             return [
                'name'=>'required|max:255',
                'details'=>'required',
                
                'brand'=>'required',
                'category'=>'required',
                'price.*'=>'required',
             // 'sku.*'=>'required|unique:product_variants,stock_keeping_unit.ltrim(sku.*,"sku.")'
           'sku.*'=>'required | unique:product_variants,stock_keeping_unit,*',
            // 'add.variant.*'=>'required',
            
             'add.price.*'=>'required',
             'add.sku.*'=>'required|unique:product_variants,stock_keeping_unit'
             ];
          }
            
        //}
    }
}
