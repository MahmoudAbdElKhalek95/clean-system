<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required|unique:doner_types,name,'.$this->id;
        $rules['phone']      = 'required' ;
        $rules['type_id']      = 'required' ;



      
        return $rules;
    }
}
