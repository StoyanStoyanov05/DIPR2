<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingListItemResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'shopping_list' => [
                'id' => $this->shoppingList->id,
                'name' => $this->shoppingList->name,
            ],
            'ingredient' => [
                'id' => $this->ingredient->id,
                'name' => $this->ingredient->name,
            ],
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'is_purchased' => $this->is_purchased,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
