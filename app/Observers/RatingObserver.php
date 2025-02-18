<?php

namespace App\Observers;

use App\Models\Rating;
use App\Models\Recipe;

class RatingObserver
{
    public function updatedOrCreatedOrDeleted(Rating $rating)
    {
        $this->updateRecipeRating($rating->recipe_id);
    }

    private function updateRecipeRating($recipeId)
    {
        $averageRating = Rating::where('recipe_id', $recipeId)->avg('rating') ?? 0;

        Recipe::where('id', $recipeId)->update(['average_rating' => $averageRating]);
    }

    public function created(Rating $rating)
    {
        $this->updatedOrCreatedOrDeleted($rating);
    }

    public function updated(Rating $rating)
    {
        $this->updatedOrCreatedOrDeleted($rating);
    }

    public function deleted(Rating $rating)
    {
        $this->updatedOrCreatedOrDeleted($rating);
    }
}
