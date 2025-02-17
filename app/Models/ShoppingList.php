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
        return $this->hasMany(ShoppingListItem::class, 'shopping_list_id');
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
        return !$this->shoppingListItems()->where('is_purchased', false)->exists();
    }

    public function markAllAsPurchased()
    {
        return $this->shoppingListItems()->update(['is_purchased' => true]);
    }


}
