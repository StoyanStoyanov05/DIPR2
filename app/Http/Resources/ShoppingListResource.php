<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingListResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'items' => $this->shoppingListItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ingredient' => $item->ingredient->name,
                    'quantity' => $item->quantity,
                    'unit' => $item->unit,
                    'is_purchased' => $item->is_purchased,
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
