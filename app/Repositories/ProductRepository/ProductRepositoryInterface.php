<?php

namespace App\Repositories\ProductRepository;

interface ProductRepositoryInterface
{
    public function getProductsByCategoryId($id, $option);
}
