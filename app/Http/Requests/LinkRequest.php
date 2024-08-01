<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class LinkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'amount' => 'required',
            'price' => 'required',
            'project_id' => 'required',
            'phone' => 'required',
            'code' => 'required',
        ];
        return $rules;
    }
}

?>
