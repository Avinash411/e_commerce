<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class CategoryValidation extends FormRequest
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
    public function rules()
    {    
   
        return [
            'name'=>'required|unique:product_categories,category_name,'.$this->id,
            'category'=>'required'
        ];
    }
    public function messages()
    {    
        
        return [
            'name.unique'=>'Category Name must be unique.',
            'name.required'=>'Category name is required.',
            'category.required'=>'Choose Parent Category.'
        ];
    }
}
