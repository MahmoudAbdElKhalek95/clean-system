<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArchiveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']   = 'required';
        $rules['start']  = 'required';
        $rules['end']    = 'required';
        return $rules;
    }
}
