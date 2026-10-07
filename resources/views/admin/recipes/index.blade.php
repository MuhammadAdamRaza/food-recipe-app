<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf8f2">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Recipe manager — The Good Table</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}?v=20261005-planner1">
    <script src="{{ asset('js/recipes.js') }}?v=20261005-planner1" defer></script>
</head>
<body>
    @include('recipes.partials.header')
    <main class="admin-page">
        <div class="admin-page-heading">
            <div><a class="back-link" href="{{ route('recipes.index') }}">← View the public site</a><span class="eyebrow section-eyebrow">Your kitchen, your rules</span><h1>Recipe <span>manager</span></h1><p>Keep your collection fresh, one good thing at a time.</p></div>
            <a class="button button-terracotta" href="{{ route('admin.recipes.create') }}">＋ Add a recipe</a>
        </div>
        @if (session('status'))<div class="status-message" role="status">{{ session('status') }}</div>@endif
        <div class="admin-summary">
            <div><span class="summary-label">Recipes in your collection</span><strong>{{ $totalRecipes }}</strong></div>
            <div><span class="summary-label">Last updated</span><strong>{{ $recipes->first()?->updated_at?->format('M j, Y') ?? '—' }}</strong></div>
            <form class="admin-search" action="{{ route('admin.recipes.index') }}" method="GET">
                <label class="visually-hidden" for="admin-search">Search recipes</label>
                <input id="admin-search" name="q" type="search" value="{{ $search }}" placeholder="Search your recipes...">
                <label class="visually-hidden" for="admin-category">Filter by category</label>
                <select id="admin-category" name="category">
                    <option value="All" @selected($category === 'All')>All categories</option>
                    @foreach ($categories as $filterCategory)<option value="{{ $filterCategory }}" @selected($category === $filterCategory)>{{ $filterCategory }}</option>@endforeach
                </select>
                <button class="button button-dark" type="submit">Search</button>
            </form>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Recipe</th><th>Category</th><th>Time</th><th>Updated</th><th><span class="visually-hidden">Actions</span></th></tr></thead>
                <tbody>
                    @forelse ($recipes as $recipe)
                        <tr>
                            <td><div class="table-recipe"><img src="{{ $recipe->image_src }}" alt="" loading="lazy"><div><a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a><span>{{ $recipe->cuisine }}@if ($recipe->is_featured) · Featured @endif</span></div></div></td>
                            <td><span class="table-category">{{ $recipe->category }}</span></td>
                            <td>{{ $recipe->total_time }} min</td>
                            <td>{{ $recipe->updated_at->format('M j, Y') }}</td>
                            <td><div class="table-actions"><a href="{{ route('admin.recipes.edit', $recipe) }}">Edit</a><form method="POST" action="{{ route('admin.recipes.destroy', $recipe) }}" data-confirm-delete="{{ $recipe->title }}">@csrf @method('DELETE')<button type="submit">Delete</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="table-empty">No recipes found. Add your first recipe or try another search.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($recipes->hasPages())
            <nav class="pagination" aria-label="Admin recipe pages">
                @if ($recipes->onFirstPage())<span class="pagination-disabled">← Previous</span>@else<a href="{{ $recipes->previousPageUrl() }}">← Previous</a>@endif
                <span>Page {{ $recipes->currentPage() }} of {{ $recipes->lastPage() }}</span>
                @if ($recipes->hasMorePages())<a href="{{ $recipes->nextPageUrl() }}">Next →</a>@else<span class="pagination-disabled">Next →</span>@endif
            </nav>
        @endif
    </main>
    @include('recipes.partials.footer')
</body>
</html>
