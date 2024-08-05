<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class SalaryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['worker_id']      = 'required';
        return $rules;
    }
}

?>
