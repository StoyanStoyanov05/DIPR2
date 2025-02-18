<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopping_list_id',
        'ingredient_id',
        'quantity',
        'unit',
        'is_purchased',
    ];

    protected $casts = [
        'quantity' => 'float',
        'is_purchased' => 'boolean',
    ];

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function scopePurchased($query)
    {
        return $query->where('is_purchased', true);
    }

    public function scopeNotPurchased($query)
    {
        return $query->where('is_purchased', false);
    }

    public function scopeForShoppingList($query, $shoppingListId)
    {
        return $query->where('shopping_list_id', $shoppingListId);
    }

    public function getQuantityUnitTextAttribute()
    {
        return "{$this->quantity} {$this->unit}";
    }

    public function markAsPurchased()
    {
        $this->update(['is_purchased' => true]);
    }
}
