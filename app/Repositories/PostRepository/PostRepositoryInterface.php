<?php

namespace App\Repositories\PostRepository;

interface PostRepositoryInterface
{
    public function getPostsByCategory($option);
}
