<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ProjectPhoneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['phone']           = 'required';
        $rules['category_id']      = 'required|exists:categories,id' ;
        $rules['project_id']        = 'required|exists:projects,id' ;

        return $rules;
    }
}

?>
