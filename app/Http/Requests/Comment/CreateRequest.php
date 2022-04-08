<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'content' => 'required|string|unique:posts,title|max:100',
            'reply_comment_id' => 'nullable|exists:comments,id',
            'user_id' => ['required', 'exists:users,id', function ($attribute, $value, $fail) {
                if (Auth::id() != $value) {
                    $fail('The ' . $attribute . ' is not correct!');
                }
            }],
            'post_id' => ['required', 'exists:posts,id', function ($attribute, $value, $fail) {
                if ($this->reply_comment_id) {
                    $reply_comment = Comment::where('id', $this->reply_comment_id)->first();
                    if ($reply_comment && $reply_comment->post_id != $value) {
                        $fail('The ' . $attribute . ' is not correct!');
                    }
                }
            }]
        ];
    }
}
