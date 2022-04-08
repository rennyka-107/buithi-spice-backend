<?php

namespace App\Services\ProductService;

interface ProductServiceInterface
{
    public function getProductsByCategoryId($id, $option);
}
