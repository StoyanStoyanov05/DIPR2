<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function ingredients()
    {
        return $this->hasManyThrough(
            Ingredient::class,
            RecipeIngredient::class,
            'recipe_id',      
            'id',             
            'id',             
            'ingredient_id'   
        );
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeHighRated($query, $rating = 4.0)
    {
        return $query->where('rating', '>=', $rating);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/recipes/' . $this->image) : null;
    }
}
