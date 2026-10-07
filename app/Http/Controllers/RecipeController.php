<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index(Request $request): View
    {
        $categories = ['Breakfast', 'Lunch', 'Dinner', 'Dessert', 'Snacks'];
        $category = $request->query('category', 'All');

        if (! in_array($category, [...$categories, 'All'], true)) {
            $category = 'All';
        }

        $search = trim((string) $request->query('q', ''));
        $sort = $request->query('sort', 'popular');
        $savedIds = $request->session()->get('favorite_recipe_ids', []);

        $query = Recipe::query()
            ->when(in_array($category, $categories, true), fn (Builder $builder) => $builder->where('category', $category))
            ->when($search !== '', function (Builder $builder) use ($search): void {
                $builder->where(function (Builder $searchQuery) use ($search): void {
                    $searchQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('cuisine', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('ingredients', 'like', "%{$search}%");
                });
            })
            ->when($request->boolean('saved'), fn (Builder $builder) => $builder->whereIn('id', $savedIds));

        match ($sort) {
            'quickest' => $query->orderByRaw('(prep_time + cook_time) asc'),
            'name' => $query->orderBy('title'),
            default => $query->orderByDesc('rating')->orderBy('title'),
        };

        $recipes = $query->paginate(9)->withQueryString();
        $recipeCount = Recipe::query()->count();
        $featuredRecipe = Recipe::query()->where('is_featured', true)->orderByDesc('rating')->first();

        return view('recipes.catalog', compact('recipes', 'recipeCount', 'categories', 'category', 'search', 'sort', 'savedIds', 'featuredRecipe'));
    }

    public function show(Recipe $recipe, Request $request): View
    {
        $relatedRecipes = Recipe::query()
            ->where('category', $recipe->category)
            ->whereKeyNot($recipe->getKey())
            ->orderByDesc('rating')
            ->limit(3)
            ->get();

        return view('recipes.show', [
            'recipe' => $recipe,
            'savedIds' => $request->session()->get('favorite_recipe_ids', []),
            'relatedRecipes' => $relatedRecipes,
        ]);
    }

    public function planner(): View
    {
        $recipes = Recipe::query()->orderBy('category')->orderBy('title')->get();

        return view('recipes.planner', compact('recipes'));
    }

    public function toggleFavorite(Recipe $recipe, Request $request): RedirectResponse
    {
        $savedIds = $request->session()->get('favorite_recipe_ids', []);

        if (in_array($recipe->id, $savedIds, true)) {
            $savedIds = array_values(array_diff($savedIds, [$recipe->id]));
            $message = 'Recipe removed from your saved list.';
        } else {
            $savedIds[] = $recipe->id;
            $message = 'Recipe saved for later.';
        }

        $request->session()->put('favorite_recipe_ids', $savedIds);

        return back()->with('status', $message);
    }
}
