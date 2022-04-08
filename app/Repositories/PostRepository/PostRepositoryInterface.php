<?php

namespace App\Repositories\PostRepository;

interface PostRepositoryInterface
{
    public function getPostsByCategoryId($id, $option);
}
