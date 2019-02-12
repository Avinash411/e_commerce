<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class VariantValueValidation extends FormRequest
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
        $this->replace(['name' => explode(',', $this->name),'variant'=>$this->variant]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'variant'=>'required',
           // 'name'=>'required'


        //bail is like stop validation till string to array convert
           'name'=>'required|bail|array',
           //checking each combination value name and variant name that will be unique
            'name.*' => 'string|unique:variant__values,variant_value,NULL,id,variant_id,' . Input::get('variant')
        ];
    }
     public function messages()
    {    
        
        return [
            


'name.*.unique'=>'Variant Name and Variant Value already exist.',
              'name.*'=>'Not valid name.',


            'name.required'=>'Variant Value name is required.',
            'variant.required'=>'Choose Refer Variant.'


            

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
