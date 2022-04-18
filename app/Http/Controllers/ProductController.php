<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\GetAllProductByCategoryRequest;
use App\Http\Requests\Product\GetAllProductRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Services\ProductService\ProductServiceInterface as ProductService;

class ProductController extends Controller
{
    protected $product_service;
    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function getAll(GetAllProductRequest $request)
    {
        try {
            $products = $this->product_service->getAll($request->all());
            return response()->json(["status" => count($products) > 0, "products" => $products]);
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
            $product = $this->product_service->create($request->all());
            return response()->json(["status" => $product !== null, "product" => $product]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        try {
            $product = $this->product_service->get($id);
            return response()->json(["status" => $product !== null, "product" => $product]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $request['id'] = $id;
            $product = $this->product_service->update($request->all());
            return response()->json(["status" => $product !== null, "product" => $product]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            return response()->json(["status" => $this->product_service->delete($id)]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function getProductsByCategory(GetAllProductByCategoryRequest $request)
    {
        try {
            $data = $this->product_service->getProductsByCategory($request->all());
            $data['status'] = count($data['products']) > 0;
            return response()->json($data);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function getBySlug($slug)
    {
        try {
            $product = $this->product_service->getBySlug($slug);
            return response()->json(["status" => $product !== null, "product" => $product]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }
}
