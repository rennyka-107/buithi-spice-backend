<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\GetAllPostRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Requests\Post\GetAllPostByCategoryRequest;
use App\Services\PostService\PostServiceInterface as PostService;

class PostController extends Controller
{
    protected $post_service;
    public function __construct(PostService $post_service)
    {
        $this->post_service = $post_service;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function getAll(GetAllPostRequest $request)
    {
        try {
            $posts = $this->post_service->getAll($request->all());
            return response()->json(["status" => count($posts) > 0, "posts" => $posts]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request)
    {
        try {
            $post = $this->post_service->create($request->all());
            return response()->json(["status" => $post !== null, "post" => $post]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        try {
            $post = $this->post_service->get($id);
            return response()->json(["status" => $post !== null, "post" => $post]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $request['id'] = $id;
            $post = $this->post_service->update($request->all());
            return response()->json(["status" => $post !== null, "post" => $post]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            return response()->json(["status" => $this->post_service->delete($id)]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function getPostsByCategory(GetAllPostByCategoryRequest $request)
    {
        try {
            $data = $this->post_service->getPostsByCategory($request->all());
            $data['status'] = count($data['posts']) > 0;
            return response()->json($data);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function getBySlug($slug)
    {
        try {
            $post = $this->post_service->getBySlug($slug);
            return response()->json(["status" => $post !== null, "post" => $post]);
        } catch (Exception $error) {
            return response()->withCookie(cookie('name', 'kaka', 3600))->json(['error' => $error->getMessage()]);
        }
    }
}
