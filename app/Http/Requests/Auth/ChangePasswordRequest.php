<?php

namespace App\Http\Requests\Auth;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', function ($att, $value, $fail) {
                $email_user = Auth::user()->email;
                if ($email_user && $email_user !== $value) {
                    $fail('The ' . $att . ' is not correct!');
                }
            }],
            'password' => 'required',
            'new_password' => 'required',
        ];
    }
}
