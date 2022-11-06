<?php

namespace App\Http\Requests;

class TokenRequest extends FormRequest
{
    protected function afterValidationPasses()
    {
      //i could do something here after the validation
    }

    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => ':attribute must be an email',
            'email.required' => ':attribute is required',
            'password.required' => ':attribute is required',
        ];
    }
}
