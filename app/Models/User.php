<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens , HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function shoppingLists()
    {
        return $this->hasMany(ShoppingList::class);
    }

    public function notifyForUnpurchasedItems()
    {
        $lists = $this->shoppingLists()->whereHas('shoppingListItems', function ($query) {
            $query->where('is_purchased', false);
        })->get();

        return $lists->map(function ($list) {
            return "Напомняне: списъка \"{$list->name}\" все още има незакупени продукти!";
        });
    }
}
