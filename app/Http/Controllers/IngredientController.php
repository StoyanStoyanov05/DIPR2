<?php

namespace App\Http\Controllers;

use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        return IngredientResource::collection(Ingredient::paginate(10)); // Добавена пагинация
    }

    public function show(Ingredient $ingredient)
    {
        return new IngredientResource($ingredient);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_allergen' => 'nullable|boolean',
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ingredients', 'public');
        }

        $ingredient = Ingredient::create(array_filter($validated)); 

        return new IngredientResource($ingredient);
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_allergen' => 'nullable|boolean',
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ingredients', 'public');
        }

        $ingredient->updateOrFail(array_filter($validated));

        return new IngredientResource($ingredient);
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return response()->json(null, 204);
    }
}
