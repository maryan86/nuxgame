<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'phonenumber' => ['required', 'string', 'max:20', 'unique:users,phonenumber', 'regex:/^\+?[0-9]{10,15}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required',
            'username.unique' => 'This username is already taken',
            'phonenumber.required' => 'Phone number is required',
            'phonenumber.unique' => 'This phone number is already registered',
            'phonenumber.regex' => 'Please enter a valid phone number',
        ];
    }
}
