<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'password' => 'required',
            'email' => 'required|string|email|unique:users',
            'avatar' => 'nullable|file|mimes:jpeg,jpg,png',
            'code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'password.required' => 'Password is required and > 8 characters!',
            'email.required' => 'Email is required!',
        ];
    }
}
