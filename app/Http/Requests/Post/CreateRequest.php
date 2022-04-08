<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:posts,title|max:100',
            'description' => 'required|string|max:255',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|file|mimes:jpeg,jpg,png',
            'slug' => 'required|string|unique:posts,slug|max:255',
        ];
    }
}
