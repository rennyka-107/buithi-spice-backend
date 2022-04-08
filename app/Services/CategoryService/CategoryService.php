<?php

namespace App\Services\CategoryService;

use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\CategoryRepository\CategoryRepositoryInterface as CategoryRepository;
use App\Services\BaseService;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    protected $category_repository;
    public function __construct(CategoryRepository $category_repository)
    {
        $this->category_repository = $category_repository;
    }
    public function get($id)
    {
        $category = $this->category_repository->get($id);
        return $category ? new CategoryResource($category) : null;
    }
    public function getAll($option)
    {
        return new CategoryCollection($this->category_repository->getAll($option));
    }
    public function create($data)
    {
        $category = $this->category_repository->create($data);
        return $category ? new CategoryResource($category) : null;
    }
    public function update($data)
    {
        $category = $this->category_repository->update($data);
        return $category ? new CategoryResource($category) : null;
    }
    public function delete($id)
    {
        return $this->category_repository->delete($id);
    }
}
