<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => ['required', 'string', 'max:100', Rule::unique('posts', 'title')->where(function ($query) {
                return $query->where('id', '<>', $this->route('id'));
            })],
            'description' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'file|mimes:jpeg,jpg,png',
            'slug' => 'required|string|unique:posts,slug|max:255',
        ];
    }
}
