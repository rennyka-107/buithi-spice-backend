<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\GetAllCategoryRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Services\CategoryService\CategoryServiceInterface as CategoryService;

class CategoryController extends Controller
{
    protected $category_service;
    public function __construct(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function getAll(GetAllCategoryRequest $request)
    {
        try {
            $categories = $this->category_service->getAll($request->all());
            return response()->json(["status" => count($categories) > 0 ,"categories" => $categories]);
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
            $category = $this->category_service->create($request->all());
            return response()->json(["status" => $category !== null, "category" => $category]);
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
            $category = $this->category_service->get($id);
            return response()->json(["status" => $category !== null, "category" => $category]);
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
            $category = $this->category_service->update($request->all());
            return response()->json(["status" => $category !== null, "category" => $category]);
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
            return response()->json(["status" => $this->category_service->delete($id)]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }
}
