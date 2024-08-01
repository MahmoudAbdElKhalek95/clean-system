<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class WhatsappPhoneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules['name']           = 'required';
        $rules['listen_id']      = 'required' ;
        $rules['token_id']        = 'required' ;

        return $rules;
    }
}

?>
