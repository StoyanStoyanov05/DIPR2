<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Resources\RatingResource;

class RatingController extends Controller
{
    public function index()
    {
        return RatingResource::collection(Rating::paginate(10)); // Пагинация
    }

    public function show(Rating $rating)
    {
        return new RatingResource($rating);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'recipe_id' => 'required|exists:recipes,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rating = Rating::create($validated);
        return new RatingResource($rating);
    }

    public function update(Request $request, Rating $rating)
    {
        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rating->update(array_filter($validated));
        return new RatingResource($rating);
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();
        return response()->json(null, 204);
    }
}
