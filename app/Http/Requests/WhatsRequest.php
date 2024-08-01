<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhatsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'category_id' => 'required',
            'type' => 'required|in:zero,percent',
            'percent' => 'required_if:type,percent',
            'percent2' => 'required_if:type,percent',
            'message' => 'required',
        ];
        return $rules;
    }
}
