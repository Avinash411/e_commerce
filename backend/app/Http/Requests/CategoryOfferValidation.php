<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryOfferValidation extends FormRequest
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
            'choose_category'=>'required',
            'type'=>'required',
            'amount'=>'required',
           
            'from'=>'date_format:"d/m/Y"|required',
            'from_t'=>'date_format:"h:i A"|required',
            'to'=>'date_format:"d/m/Y"|required',
            'to_t'=>'date_format:"h:i A"|required'
        ];
    }
}
