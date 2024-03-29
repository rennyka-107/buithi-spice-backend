<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->where(function ($query) {
                return $query->where('id', '<>', $this->route('id'));
            })],
            'description' => 'required|string|max:255',
            'image' => 'file|mimes:jpeg,jpg,png|nullable',
        ];
    }
}
