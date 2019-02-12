<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
class BrandValidation extends FormRequest
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
            
            'name'=>'required',
            'details'=>'required',
            //'category'=>'required'
        'category.*' => '
        required|unique:brands,category_id,NULL,id,brand_name,' . Input::get('name')


      //  'building_id' => 'unique:devplans,building_id,NULL,id,level_id,' . Input::get('level_id')
];
        
    }

    public function messages()
    {    
        
        return [
            'category.*.unique'=>'Combination of Brand Name and Category must be unique.',
///combination of name category is pending
            'name.required'=>'Brand name is required.',
            'category.required'=>'Choose Refer Category.'
        ];
    }


//     $messages = [
//     'name.unique' = 'Brand Name and Refer Category are not unique'
// ];

// Validator::make($data, [
//     'category' => [
//         'required',
//         Rule::unique('brands')->where(function ($query) use($ip,$hostname) {
//             return $query->where('ip', $ip)
//             ->where('hostname', $hostname);
//         }),
//     ],
// ],
// $messages
// );
    //'unique:brands,brand_name,NULL,id,level_id,' . Input::get('level_id')
}
