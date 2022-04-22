<?php

namespace App\Http\Resources\Product;

use App\Services\Firebase\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'slug' => $this->slug,
            'image' => $this->image,
            'image_url' => $this->image ? ImageService::getUrlImageFirebase($this->image, "Products/") : null,
            'category' => $this->category->name,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
        ];
    }
}
