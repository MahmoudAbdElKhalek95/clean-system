<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonerTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required|unique:doner_types,name,'.$this->id;
        $rules['from']      = 'sometimes|nullable|numeric|min:0';
        $rules['to']         = 'sometimes|nullable|numeric|gte:from';
        return $rules;
    }
}
