<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class InitiativeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']         = 'required';
        $rules['code']         = 'nullable|unique:initiatives,code,' . $this->id;
        $rules['path_id']      = 'required|exists:paths,id';

        return $rules;
    }
}

?>
