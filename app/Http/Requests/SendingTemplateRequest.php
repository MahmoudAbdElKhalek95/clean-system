<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class SendingTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['template_name']             = 'required';
        return $rules;
    }
}

?>
