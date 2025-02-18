<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RecipeResource;

class RecipeController extends Controller
{
    public function index()
    {
        return RecipeResource::collection(Recipe::with(['ingredients', 'user'])->paginate(10)); 
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe->load(['ingredients', 'user']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' => 'required|exists:users,id',
            'rating' => 'nullable|numeric|between:1,5',
        ]);

        try {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('recipes', 'public');
            }

            $recipe = Recipe::create(array_filter($validated));
            return new RecipeResource($recipe);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Неуспешно записване на рецептата'], 500);
        }
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'rating' => 'nullable|numeric|between:1,5',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($recipe->image) {
                    Storage::disk('public')->delete($recipe->image);
                }
                $validated['image'] = $request->file('image')->store('recipes', 'public');
            }

            $recipe->update(array_filter($validated));
            return new RecipeResource($recipe);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Неуспешно обновяване на рецептата'], 500);
        }
    }

    public function destroy(Recipe $recipe)
    {
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();
        return response()->json(null, 204);
    }
}
