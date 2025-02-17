<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index()
    {
        return ShoppingList::with('shoppingListItems.ingredient')->get();
    }

    public function show($id)
    {
        $shoppingList = ShoppingList::with('shoppingListItems.ingredient')->findOrFail($id);
        return response()->json($shoppingList);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
        ]);

        $shoppingList = ShoppingList::create($validated);
        return response()->json($shoppingList, 201);
    }

    public function update(Request $request, $id)
    {
        $shoppingList = ShoppingList::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $shoppingList->update($validated);
        return response()->json($shoppingList);
    }

    public function destroy($id)
    {
        $shoppingList = ShoppingList::findOrFail($id);
        $shoppingList->delete();

        return response()->json(null, 204);
    }

    public function downloadShoppingListPdf($id)
    {
        $shoppingList = ShoppingList::with('shoppingListItems.ingredient')->findOrFail($id);

        $pdf = PDF::loadView('pdf.shopping_list', compact('shoppingList'));

        return $pdf->download("shopping_list_{$shoppingList->id}.pdf");
    }
}
