<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'name',    
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shoppingListItems()
    {
        return $this->hasMany(ShoppingListItem::class);
    }

    public function unpurchasedItems()
    {
        return $this->shoppingListItems()->where('is_purchased', false);
    }

    public function purchasedItems()
    {
        return $this->shoppingListItems()->where('is_purchased', true);
    }

    public function remainingItemsCount()
    {
        return $this->shoppingListItems()->where('is_purchased', false)->count();
    }

    public function isCompleted()
    {
        return !$this->unpurchasedItems()->exists();
    }

    public function markAllAsPurchased()
    {
        return $this->unpurchasedItems()->update(['is_purchased' => true]);
    }

    public function hasUnpurchasedItems()
    {
        return $this->unpurchasedItems()->exists();
    }

    public function deleteIfEmpty()
    {
        if (!$this->shoppingListItems()->exists()) {
            $this->delete();
        }
    }
}
