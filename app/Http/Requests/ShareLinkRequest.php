<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ShareLinkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']            = 'required';
        $rules['project_id']      = 'required|exists:projects,id' ;


        return $rules;
    }
}

?>
