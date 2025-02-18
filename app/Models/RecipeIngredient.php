<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',      
        'ingredient_id',  
        'quantity',       
        'unit',           
    ];

    protected $casts = [
        'quantity' => 'float',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function scopeByRecipe($query, $recipeId)
    {
        return $query->where('recipe_id', $recipeId);
    }

    public function scopeByIngredient($query, $ingredientId)
    {
        return $query->where('ingredient_id', $ingredientId);
    }
}
