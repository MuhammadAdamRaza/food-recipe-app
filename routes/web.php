<?php

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\RecipeAdminController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;
Route::get('/', [RecipeController::class, 'index'])->name('recipes.index');
Route::view('/about', 'recipes.about')->name('recipes.about');
Route::view('/kitchen-guide', 'recipes.kitchen-guide')->name('recipes.kitchen-guide');
Route::get('/meal-planner', [RecipeController::class, 'planner'])->name('recipes.planner');

Route::get('/recipes/{recipe:slug}', [RecipeController::class, 'show'])->name('recipes.show');
Route::post('/recipes/{recipe:slug}/favorite', [RecipeController::class, 'toggleFavorite'])->name('recipes.favorite');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::get('/admin/login', [RecipeAdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [RecipeAdminController::class, 'login'])->name('admin.login.store');

Route::middleware('recipe.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/recipes', [RecipeAdminController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeAdminController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [RecipeAdminController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', [RecipeAdminController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{recipe}', [RecipeAdminController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeAdminController::class, 'destroy'])->name('recipes.destroy');
});

// Keep the old dashboard URL pointing to the recipe manager.
Route::get('/customer', fn () => redirect()->route('admin.recipes.index'))
    ->middleware('recipe.admin');

Route::post('/admin/logout', [RecipeAdminController::class, 'logout'])
    ->middleware('recipe.admin')
    ->name('admin.logout');

// Support sign-out forms rendered before the admin route was renamed.
Route::post('/logout', [RecipeAdminController::class, 'logout'])
    ->middleware('recipe.admin');
