<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Auth;
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
        $comment = null;
        if ($this->user_id || $this->reply_comment_id) {
            $comment = Comment::where('id', $this->id)->first();
        }
        return [
            'content' => 'string|unique:posts,title|max:100',
            'reply_comment_id' => ['nullable', 'exists:comments,id', function ($attribute, $value, $fail) use ($comment) {
                $reply_comment = Comment::where('id', $value)->first();
                if ($comment->post_id !== $reply_comment->post_id) {
                    $fail('The ' . $attribute . ' is not correct!');
                }
            }],
            'user_id' => ['required', 'exists:users,id', function ($attribute, $value, $fail) use ($comment) {
                if (Auth::id() != $value || !$comment || ($comment && $comment->user_id != $value)) {
                    $fail('The ' . $attribute . ' is not correct!');
                }
            }],
            'post_id' => ['exists:posts,id', function ($attribute, $value, $fail) use ($comment) {
                if ($comment->replies || $comment->reply_comment_id) {
                    $fail('The ' . $attribute . ' cannot change!');
                }
            }]
        ];
    }
}
