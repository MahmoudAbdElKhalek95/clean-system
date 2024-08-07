<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class BackageDetailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['backage_id']      = 'required';
        $rules['school_id']      = 'required';
        $rules['month']        = 'required';


        return $rules;
    }
}

?>
