<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class SectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required';
        $rules['code']      = 'required|unique:sections,code,'.$this->id;
        return $rules;
    }
}

?>
