<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class TargetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['date_type']            = 'required|in:1,2';
        $rules['day']            = 'required_if:date_type,1';
        $rules['date_from']            = 'required_if:date_type,2';
        $rules['date_to']            = 'required_if:date_type,2';
        $rules['target']         = 'required';
        $rules['section_id']     = 'required';
        return $rules;
    }
}

?>
