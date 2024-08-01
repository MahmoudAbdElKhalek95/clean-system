<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['first_name']      = 'required';
        $rules['mid_name']      = 'required';

        if ($this->method() == "POST") {
            $rules['code']     = 'nullable|unique:users';
            $rules['phone']     = 'required_if:type,3|unique:users';
            $rules['password']     = 'required_if:type,3';
        } else {
            $rules['code']     = 'nullable|unique:users,code,' . $this->id;
            $rules['phone']     = 'required_if:type,3|unique:users,phone,' . $this->id;
        }

        return $rules;
    }
}

?>
