<?php

namespace App\Repositories\CategoryRepository;

use App\Models\Category;
use App\Repositories\BaseRepository;
use App\Services\Firebase\ImageService;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function get($id)
    {
        try {
            return Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function getAll($option)
    {
        return Category::paginate($option['size']);;
    }

    public function create($data)
    {
        if ($image = $data['image']) {
            unset($data['image']);
            $data['image'] = ImageService::uploadImageClientToFirebase($image, $data['name'], "Categories/");
        }

        try {
            $new_category = Category::create($data);
            return $new_category;
        } catch (Exception $e) {
            return null;
        }
    }

    public function update($data)
    {
        try {
            $category = Category::findOrFail($data['id']);
            if ($data['image']) {
                $image = $data['image'];
                unset($data['image']);
                ImageService::deleteImageFirebase($category['name'] . '.' . $image->getClientOriginalExtension(), "Categories/");
                $data['image'] = ImageService::uploadImageClientToFirebase($image, $category['name'], "Categories/");
            } else {
                unset($data['image']);
            }
            $category->update($data);
            return $category;
        } catch (Exception $e) {
            return null;
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::findOrFail($id);
            if ($category['image']) {
                ImageService::deleteImageFirebase($category['image'], "Categories/");
            }
            $category->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
