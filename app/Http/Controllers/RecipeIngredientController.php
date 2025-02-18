<?php

namespace App\Http\Controllers;

use App\Models\RecipeIngredient;
use Illuminate\Http\Request;
use App\Http\Resources\RecipeIngredientResource;

class RecipeIngredientController extends Controller
{
    public function index()
    {
        return RecipeIngredientResource::collection(
            RecipeIngredient::with(['recipe', 'ingredient'])->paginate(10)
        );
    }

    public function show(RecipeIngredient $recipeIngredient)
    {
        return new RecipeIngredientResource($recipeIngredient);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
        ]);

        $recipeIngredient = RecipeIngredient::create($validated);
        return new RecipeIngredientResource($recipeIngredient);
    }

    public function update(Request $request, RecipeIngredient $recipeIngredient)
    {
        $validated = $request->validate([
            'quantity' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
        ]);

        $recipeIngredient->update(array_filter($validated));
        return new RecipeIngredientResource($recipeIngredient);
    }

    public function destroy(RecipeIngredient $recipeIngredient)
    {
        $recipeIngredient->delete();
        return response()->json(null, 204);
    }
}
