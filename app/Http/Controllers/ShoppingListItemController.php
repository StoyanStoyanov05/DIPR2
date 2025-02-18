<?php

namespace App\Http\Controllers;

use App\Models\ShoppingListItem;
use Illuminate\Http\Request;
use App\Http\Resources\ShoppingListItemResource;

class ShoppingListItemController extends Controller
{
    public function index()
    {
        return ShoppingListItemResource::collection(
            ShoppingListItem::with(['ingredient', 'shoppingList'])->paginate(10)
        );
    }

    public function show(ShoppingListItem $shoppingListItem)
    {
        return new ShoppingListItemResource($shoppingListItem);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shopping_list_id' => 'required|exists:shopping_lists,id',
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'is_purchased' => 'nullable|boolean',
        ]);

        $item = ShoppingListItem::create($validated);
        return new ShoppingListItemResource($item);
    }

    public function update(Request $request, ShoppingListItem $shoppingListItem)
    {
        $validated = $request->validate([
            'quantity' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'is_purchased' => 'nullable|boolean',
        ]);

        $shoppingListItem->update($validated);
        return new ShoppingListItemResource($shoppingListItem);
    }

    public function markAsPurchased(ShoppingListItem $shoppingListItem)
    {
        $shoppingListItem->markAsPurchased();
        return new ShoppingListItemResource($shoppingListItem);
    }

    public function markAsNotPurchased(ShoppingListItem $shoppingListItem)
    {
        $shoppingListItem->markAsNotPurchased();
        return new ShoppingListItemResource($shoppingListItem);
    }

    public function destroy(ShoppingListItem $shoppingListItem)
    {
        $shoppingListItem->delete();
        return response()->json(null, 204);
    }
}
