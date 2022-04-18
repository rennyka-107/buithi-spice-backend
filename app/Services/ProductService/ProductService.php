<?php

namespace App\Services\ProductService;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Repositories\ProductRepository\ProductRepositoryInterface as ProductRepository;
use App\Services\BaseService;

class ProductService extends BaseService implements ProductServiceInterface
{
    protected $product_repository;
    public function __construct(ProductRepository $product_repository)
    {
        $this->product_repository = $product_repository;
    }
    public function get($id)
    {
        $product = $this->product_repository->get($id);
        return $product ? new ProductResource($product) : null;
    }
    public function getAll($option)
    {
        return new ProductCollection($this->product_repository->getAll($option));
    }
    public function create($data)
    {
        $product = $this->product_repository->create($data);
        return $product ? new ProductResource($product) : null;
    }
    public function update($data)
    {
        $product = $this->product_repository->update($data);
        return $product ? new ProductResource($product) : null;
    }
    public function delete($id)
    {
        return $this->product_repository->delete($id);
    }
    public function getProductsByCategory($option)
    {
        $products = $this->product_repository->getProductsByCategory($option);
        return ["products" => new ProductCollection($products), "total" => $products->total()];
    }
    public function getBySlug($slug)
    {
        $product = $this->product_repository->getBySlug($slug);
        return $product ? new ProductResource($product) : null;
    }
}
