<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required';
        $rules['phone']      = 'required|unique:doners,phone,'.$this->id;
        $rules['doner_type_id']      = 'required|exists:doner_types,id';
        return $rules;
    }
}
