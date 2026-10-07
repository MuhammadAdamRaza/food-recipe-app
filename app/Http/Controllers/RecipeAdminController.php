<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RecipeAdminController extends Controller
{
    private const CATEGORIES = ['Breakfast', 'Lunch', 'Dinner', 'Dessert', 'Snacks'];

    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.recipes.index');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'The email or password is incorrect.'])->onlyInput('email');
        }

        if (! Auth::user() instanceof User || ! Auth::user()->is_admin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'This account does not have recipe administrator access.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.recipes.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $category = $request->query('category', 'All');
        $categories = self::CATEGORIES;

        if (! in_array($category, [...$categories, 'All'], true)) {
            $category = 'All';
        }

        $recipes = Recipe::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($searchQuery) use ($search): void {
                    $searchQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('cuisine', 'like', "%{$search}%");
                });
            })
            ->when($category !== 'All', fn ($query) => $query->where('category', $category))
            ->orderByDesc('updated_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.recipes.index', [
            'recipes' => $recipes,
            'search' => $search,
            'category' => $category,
            'categories' => $categories,
            'totalRecipes' => Recipe::query()->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.recipes.form', [
            'recipe' => new Recipe(['difficulty' => 'Easy', 'servings' => 4, 'prep_time' => 15]),
            'categories' => self::CATEGORIES,
            'formAction' => route('admin.recipes.store'),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $recipe = Recipe::query()->create($this->validatedRecipe($request));
        $this->replaceUploadedImage($request, $recipe);

        return redirect()->route('admin.recipes.index')->with('status', "'{$recipe->title}' was added to the recipe collection.");
    }

    public function edit(Recipe $recipe): View
    {
        return view('admin.recipes.form', [
            'recipe' => $recipe,
            'categories' => self::CATEGORIES,
            'formAction' => route('admin.recipes.update', $recipe),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        $oldImage = $recipe->image_url;
        $recipe->update($this->validatedRecipe($request, $recipe));
        $this->replaceUploadedImage($request, $recipe, $oldImage);

        return redirect()->route('admin.recipes.index')->with('status', "'{$recipe->title}' was updated.");
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        $title = $recipe->title;
        $image = $recipe->image_url;
        $recipe->delete();
        $this->deleteUploadedImage($image);

        return redirect()->route('admin.recipes.index')->with('status', "'{$title}' was deleted.");
    }

    private function validatedRecipe(Request $request, ?Recipe $recipe = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:90'],
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'cuisine' => ['required', 'string', 'max:40'],
            'description' => ['required', 'string', 'max:180'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'prep_time' => ['required', 'integer', 'min:1', 'max:1440'],
            'cook_time' => ['required', 'integer', 'min:0', 'max:1440'],
            'servings' => ['required', 'integer', 'min:1', 'max:50'],
            'difficulty' => ['required', Rule::in(['Easy', 'Medium', 'Advanced'])],
            'ingredients' => ['required', 'array', 'min:1', 'max:100'],
            'ingredients.*' => ['required', 'string', 'max:500'],
            'instructions' => ['required', 'array', 'min:1', 'max:100'],
            'instructions.*' => ['required', 'string', 'max:2000'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);
        $slugQuery = Recipe::query()->where('slug', $slug);

        if ($recipe) {
            $slugQuery->whereKeyNot($recipe->getKey());
        }

        if ($slugQuery->exists()) {
            $slug .= '-' . Str::lower(Str::random(5));
        }

        unset($validated['image_file']);

        return [
            ...$validated,
            'slug' => $slug,
            'ingredients' => $this->cleanLines($validated['ingredients']),
            'instructions' => $this->cleanLines($validated['instructions']),
            'image_url' => $recipe?->image_url,
            'is_featured' => $request->boolean('is_featured'),
        ];
    }

    private function replaceUploadedImage(Request $request, Recipe $recipe, ?string $oldImage = null): void
    {
        $image = $request->file('image_file');

        if (! $image instanceof UploadedFile) {
            return;
        }

        $directory = public_path('images/recipes');
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid() . '.' . $image->extension();
        $image->move($directory, $filename);
        $imagePath = 'images/recipes/' . $filename;

        $recipe->update(['image_url' => $imagePath]);
        $this->deleteUploadedImage($oldImage);
    }

    private function deleteUploadedImage(?string $image): void
    {
        if (! $image || ! Str::startsWith($image, 'images/recipes/')) {
            return;
        }

        $path = public_path($image);

        if (File::isFile($path)) {
            File::delete($path);
        }
    }

    private function cleanLines(array $lines): array
    {
        return array_values(array_filter(
            array_map('trim', $lines),
            fn (string $line): bool => $line !== '',
        ));
    }
}
