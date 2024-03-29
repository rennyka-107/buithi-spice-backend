<?php

namespace App\Repositories\PostRepository;

use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Services\Firebase\ImageService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function get($id)
    {
        try {
            return Post::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function getAll($option)
    {
        return Post::paginate($option['size']);
    }

    public function create($data)
    {
        if ($image = $data['image']) {
            unset($data['image']);
            $data['image'] = ImageService::uploadImageClientToFirebase($image, $data['slug'], "Posts/");
        }

        try {
            $new_post = Post::create($data);
            return $new_post;
        } catch (Exception $e) {
            return null;
        }
    }

    public function update($data)
    {
        try {
            $post = Post::findOrFail($data['id']);
            if ($data['image']) {
                $image = $data['image'];
                unset($data['image']);
                ImageService::deleteImageFirebase($post['slug'] . '.' . $image->getClientOriginalExtension(), "Posts/");
                $data['image'] = ImageService::uploadImageClientToFirebase($image, $post['slug'], "Posts/");
            } else {
                unset($data['image']);
            }

            $post->update($data);
            return $post;
        } catch (Exception $e) {
            return null;
        }
    }

    public function delete($id)
    {
        try {
            $post = Post::findOrFail($id);
            if ($post['image']) {
                ImageService::deleteImageFirebase($post['image'], "Posts/");
            }
            $post->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getPostsByCategory($option)
    {
        return Post::whereIn('category_id', $option['ids'])->paginate($option['size']);
    }

    public function getBySlug($slug)
    {
        try {
            return Post::where("slug", $slug)->first();
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}
