<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ImportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['file'] = 'required|mimes:xlsx,xls';
        $rules['section_id'] = 'required';
        $rules['type'] = 'required';
        return $rules;
    }
}

?>
