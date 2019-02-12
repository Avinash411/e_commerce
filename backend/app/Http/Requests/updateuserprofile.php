<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class updateuserprofile extends FormRequest
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
            'fname'=>'required',
             'lname'=>'required',
             'email'=>'required|email|unique:users,id,'.\Auth::user()->id,
             'phone'=>'required',
              'token' => 'required',
              'gender'=>'required'
               
        ];
    }
}
