<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class VisitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['user_id']      = 'required|exists:users,id';
        return $rules;
    }
}

?>
