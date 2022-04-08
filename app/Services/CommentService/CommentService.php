<?php

namespace App\Services\CommentService;

use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Repositories\CommentRepository\CommentRepositoryInterface as CommentRepository;
use App\Services\BaseService;

class CommentService extends BaseService implements CommentServiceInterface
{
    protected $comment_repository;
    public function __construct(CommentRepository $comment_repository)
    {
        $this->comment_repository = $comment_repository;
    }
    public function get($id)
    {
        $comment = $this->comment_repository->get($id);
        return $comment ? new CommentResource($comment) : null;
    }
    public function getAll($option)
    {
        return new CommentCollection($this->comment_repository->getAll($option));
    }
    public function create($data)
    {
        $comment = $this->comment_repository->create($data);
        return $comment ? new CommentResource($comment) : null;
    }
    public function update($data)
    {
        $comment = $this->comment_repository->update($data);
        return $comment ? new CommentResource($comment) : null;
    }
    public function delete($id)
    {
        return $this->comment_repository->delete($id);
    }
    public function getCommentsByPostId($id, $option)
    {
        $comments = $this->comment_repository->getCommentsByPostId($id, $option);
        return ["comments" => new CommentCollection($comments), "total" => $comments->total()];
    }
    public function getCommentsByUserId($id, $option)
    {
        $comments = $this->comment_repository->getCommentsByUserId($id, $option);
        return ["comments" => new CommentCollection($comments), "total" => $comments->total()];
    }
}
