<?php

namespace App\Repositories\ProductRepository;

interface ProductRepositoryInterface
{
    public function getProductsByCategory($option);
}
