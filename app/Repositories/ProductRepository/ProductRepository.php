<?php

namespace App\Repositories\ProductRepository;

use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Services\Firebase\ImageService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function get($id)
    {
        try {
            return Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function getAll($option)
    {
        return Product::orderBy('id', 'DESC')->paginate($option['size']);
    }

    public function create($data)
    {
        if ($image = $data['image']) {
            unset($data['image']);
            $data['image'] = ImageService::uploadImageClientToFirebase($image, $data['slug'], "Products/");
        }

        try {
            $new_product = Product::create($data);
            return $new_product;
        } catch (Exception $e) {
            return null;
        }
    }

    public function update($data)
    {
        try {
            $product = Product::findOrFail($data['id']);
            if ($image = $data['image']) {
                unset($data['image']);
                ImageService::deleteImageFirebase($product['slug'] . '.' . $image->getClientOriginalExtension(), "Products/");
                $data['image'] = ImageService::uploadImageClientToFirebase($image, $product['slug'], "Products/");
            }

            $product->update($data);
            return $product;
        } catch (Exception $e) {
            return null;
        }
    }

    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product['image']) {
                ImageService::deleteImageFirebase($product['image'], "Products/");
            }
            $product->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getProductsByCategory($option)
    {

        return Product::whereIn('category_id', $option['ids'])->paginate($option['size']);
    }

    public function getBySlug($slug)
    {
        try {
            return Product::where("slug", $slug)->first();
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}
