<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class VariantsValidation extends FormRequest
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


//before validation we have to make string to array
protected function prepareForValidation()
    {
        $this->replace(['name' => explode(',', $this->name),'category'=>$this->category]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [


            'category' => 'required',
        //bail is like stop validation till string to array convert
           'name'=>'required|bail|array',
           //checking each combination category and variant name that will be unique
            'name.*' => 'string|unique:variants,variant_name,NULL,id,category_id,' . Input::get('category')

        ];
    }
     public function messages()
    {    
        
        return [
             'name.*.unique'=>'Category Name and Variant already exist.',
              'name.*'=>'Not valid name.',
            'name.required'=>'Variant name is required.',
            'category.required'=>'Choose Refer Category.'
        ];
    }

     public function attributes()
    {
        $attributes = array();
        foreach ($this->name as $index=>$name) {
            $attributes['name.'.$index] = $name;
        }
        return $attributes;
    }
}
