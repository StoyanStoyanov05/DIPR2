<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use App\Http\Resources\ShoppingListResource;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ShoppingListController extends Controller
{
    public function index()
    {
        return ShoppingListResource::collection(
            ShoppingList::with('shoppingListItems.ingredient')->paginate(10)
        );
    }

    public function show(ShoppingList $shoppingList)
    {
        if ($shoppingList->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return new ShoppingListResource($shoppingList);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
        ]);

        $shoppingList = ShoppingList::create($validated);
        return new ShoppingListResource($shoppingList);
    }

    public function update(Request $request, ShoppingList $shoppingList)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $shoppingList->update($validated);
        return new ShoppingListResource($shoppingList);
    }

    public function destroy(ShoppingList $shoppingList)
    {
        $shoppingList->delete();
        return response()->json(null, 204);
    }

    public function downloadShoppingListPdf($id)
    {
        $shoppingList = ShoppingList::with('shoppingListItems.ingredient')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.shopping_list', compact('shoppingList'));
        return $pdf->download("shopping_list_{$shoppingList->id}.pdf");
    }
}
