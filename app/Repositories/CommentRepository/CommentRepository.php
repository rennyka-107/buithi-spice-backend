<?php

namespace App\Repositories\CommentRepository;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function get($id)
    {
        try {
            return Comment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function getAll($option)
    {
        return Comment::paginate($option['size']);;
    }

    public function create($data)
    {
        try {
            $new_comment = Comment::create($data);
            return $new_comment;
        } catch (Exception $e) {
            return null;
        }
    }

    public function update($data)
    {
        try {
            $comment = Comment::findOrFail($data['id']);
            $comment->update($data);
            return $comment;
        } catch (Exception $e) {
            return null;
        }
    }

    public function delete($id)
    {
        try {
            $comment = Comment::where('id', $id)->where('user_id', Auth::id())->first();
            if ($comment) {
                $comment->delete();
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getCommentsByPostId($id, $option)
    {
        return Comment::where('post_id', $id)->where('reply_comment_id', null)->paginate($option['size']);
    }

    public function getCommentsByUserId($id, $option)
    {
        return Comment::where('user_id', $id)->paginate($option['size']);
    }
}
