<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']      = 'required';
        $rules['category_number']      = 'required|unique:categories,category_number,'.$this->id;
        return $rules;
    }
}

?>
