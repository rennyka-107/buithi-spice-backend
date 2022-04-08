<?php

namespace App\Http\Resources\User;

use App\Services\Firebase\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'remember_token' => $this->remember_token,
            // 'avatar' => $this->avatar ? ImageService::getUrlImageFirebase($this->avatar, "Users/") : null,
            'avatar' => $this->avatar
        ];
    }
}
