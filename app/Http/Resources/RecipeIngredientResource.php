<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeIngredientResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'recipe' => [
                'id' => $this->recipe->id,
                'title' => $this->recipe->title,
            ],
            'ingredient' => [
                'id' => $this->ingredient->id,
                'name' => $this->ingredient->name,
            ],
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
