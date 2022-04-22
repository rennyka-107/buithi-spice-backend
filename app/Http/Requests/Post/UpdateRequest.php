<?php

namespace App\Http\Requests\Post;

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
            'title' => ['required', 'string', 'max:100', Rule::unique('posts', 'title')->where(function ($query) {
                return $query->where('id', '<>', $this->route('id'));
            })],
            'description' => 'required|string|max:255',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
            'image' => 'file|mimes:jpeg,jpg,png|nullable',
            'slug' => ['required','string','max:255', Rule::unique('posts', 'slug')->where(function ($query) {
                return $query->where('id', '<>', $this->route('id'));
            })]
        ];
    }
}
