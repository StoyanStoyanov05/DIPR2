<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\ShoppingListItemController;
use App\Http\Controllers\RecipeIngredientController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;

Route::apiResource('recipes', RecipeController::class);
Route::apiResource('ingredients', IngredientController::class);
Route::apiResource('shopping-lists', ShoppingListController::class);
Route::apiResource('ratings', RatingController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('shopping-list-items', ShoppingListItemController::class);

Route::patch('shopping-list-items/{id}/mark-as-purchased', [ShoppingListItemController::class, 'markAsPurchased']);

Route::apiResource('recipe-ingredients', RecipeIngredientController::class);

Route::get('/shopping-lists/{id}/download-pdf', [ShoppingListController::class, 'downloadShoppingListPdf']);
