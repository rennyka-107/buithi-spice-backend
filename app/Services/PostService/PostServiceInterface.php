<?php

namespace App\Services\PostService;

interface PostServiceInterface
{
    public function getPostsByCategoryId($id, $option);
}
