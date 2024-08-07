<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class BackageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required';
        $rules['subject_id']      = 'required';

        return $rules;
    }
}

?>
