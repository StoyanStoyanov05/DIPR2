<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'rating' => $this->rating,
            'image_url' => $this->image_url,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'ingredients' => $this->ingredients->pluck('name'), 
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
