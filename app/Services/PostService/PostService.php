<?php

namespace App\Services\PostService;

use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Repositories\PostRepository\PostRepositoryInterface as PostRepository;
use App\Services\BaseService;

class PostService extends BaseService implements PostServiceInterface
{
    protected $post_repository;
    public function __construct(PostRepository $post_repository)
    {
        $this->post_repository = $post_repository;
    }
    public function get($id)
    {
        $post = $this->post_repository->get($id);
        return $post ? new PostResource($post) : null;
    }
    public function getAll($option)
    {
        return new PostCollection($this->post_repository->getAll($option));
    }
    public function create($data)
    {
        $post = $this->post_repository->create($data);
        return $post ? new PostResource($post) : null;
    }
    public function update($data)
    {
        $post = $this->post_repository->update($data);
        return $post ? new PostResource($post) : null;
    }
    public function delete($id)
    {
        return $this->post_repository->delete($id);
    }
    public function getPostsByCategoryId($id, $option)
    {
        $posts = $this->post_repository->getPostsByCategoryId($id, $option);
        return ["posts" => new PostCollection($posts), "total" => $posts->total()];
    }
}
