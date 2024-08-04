<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class VisitDetailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       // $rules['user_id']      = 'required|exists:users,id';
       // $rules['visit_id']      = 'required|exists:visits,id';
        $rules['school_id']      = 'required|exists:schools,id';

        return $rules;
    }
}

?>
