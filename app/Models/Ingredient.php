<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', 
        'is_allergen',
        'category',
        'image',
        'slug',
    ];

    protected $casts = [
        'is_allergen' => 'boolean',
    ];

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients');
    }

    protected static function booted()
    {
        static::creating(function ($ingredient) {
            $ingredient->slug = Str::slug($ingredient->name);
        });

        static::addGlobalScope('alphabetical', function ($query) {
            $query->orderBy('name');
        });
    }

    public function scopeAllergens($query)
    {
        return $query->where('is_allergen', true);
    }

    public function getIsAllergenTextAttribute()
    {
        return $this->is_allergen ? 'Yes' : 'No';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/ingredients/' . $this->image) : null;
    }
}
