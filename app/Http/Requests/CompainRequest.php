<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CompainRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required';
        $rules['code']      = 'required';
         $rules['amount']      = 'required';
       /// $rules['category_id']      = 'required';
       // $rules['project_id']      = 'required';
        //$rules['marketing_project_id']      = 'required';
        $rules['sending_way']      = 'required';

        return $rules;
    }
}

?>
