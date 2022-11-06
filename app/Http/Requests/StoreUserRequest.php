<?php

namespace App\Http\Requests;

class StoreUserRequest extends FormRequest
{
    protected function afterValidationPasses()
    {
      //i could encrypt password here, but i will do it in the service
      //$this->password = sha1($this->password);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'unique:users,email|email|required',
            'password' => 'required|min:5'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
            'email.unique' => ':attribute already exists',
            'email.email' => ':attribute must be an email',
            'email.required' => ':attribute is required',
            'password.required' => ':attribute is required',
        ];
    }
}
