<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductOfferValidation extends FormRequest
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
             'choose_product_name'=>'required',
            'type'=>'required',
            'amount'=>'required',
            'from'=>'date_format:"d/m/Y"|required',
            'from_t'=>'date_format:"h:i A"|required',
            'to'=>'date_format:"d/m/Y"|required',
            'to_t'=>'date_format:"h:i A"|required'
        ];
    }
}
