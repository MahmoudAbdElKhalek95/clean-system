<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required';
        $rules['category_id']      = 'required';
        $rules['code']      = 'required|unique:projects,code,'.$this->id;
        return $rules;
    }
}

?>
