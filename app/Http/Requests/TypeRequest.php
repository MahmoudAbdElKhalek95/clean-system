<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required|unique:doner_types,name,'.$this->id;
      
        return $rules;
    }
}
