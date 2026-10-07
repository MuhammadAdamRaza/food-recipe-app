<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf8f2">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="description" content="Find something delicious to make tonight with recipes from The Good Table.">
    <title>The Good Table — recipes worth sharing</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}?v=20261005-planner1">
    <script src="{{ asset('js/recipes.js') }}?v=20261005-planner1" defer></script>
</head>
<body>
    @include('recipes.partials.header')

    <main>
        <section class="hero" aria-labelledby="hero-title">
            <div class="hero-copy">
                <span class="eyebrow"><span class="eyebrow-dot"></span> A little inspiration for your table</span>
                <h1 id="hero-title">Good food.<br>Good <span>mood.</span></h1>
                <p>Recipes made for real life, shared meals, and those “one more bite” kind of evenings.</p>
                <a class="button button-terracotta hero-cta" href="#recipes">
                    Find your next favorite
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
                <div class="hero-note">
                    <span class="hero-note-mark" aria-hidden="true">♡</span>
                    <span><strong>Made with love</strong> and a pinch of salt</span>
                </div>
            </div>
            <div class="hero-art">
                <div class="hero-image-wrap">
                    <img class="hero-image" src="{{ $featuredRecipe?->image_src ?? asset('images/hero-food.jpg') }}" alt="{{ $featuredRecipe ? 'Featured recipe: '.$featuredRecipe->title : 'A colorful, generous table of fresh food' }}">
                    <div class="hero-image-caption"><span class="caption-sparkle">♡</span><span>{{ $featuredRecipe ? 'Today’s pick:' : 'Gather round,' }}<br>{{ $featuredRecipe?->title ?: 'something good is cooking.' }}</span></div>
                </div>
                <span class="hero-sticker" aria-label="Made for sharing">made for<br>sharing <span>♡</span></span>
                <svg class="hero-squiggle" viewBox="0 0 90 54" fill="none" aria-hidden="true"><path d="M3 8c8-9 15 39 23 30 8-10 10-28 17-20 8 8 10 27 17 20 7-8 11-22 18-14 5 6 6 16 9 17" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
            </div>
        </section>

        <section class="recipe-section" id="recipes" aria-labelledby="recipes-title">
            <div class="section-heading">
                <div>
                    <span class="eyebrow section-eyebrow">Your next delicious thing</span>
                    <h2 id="recipes-title">A recipe for <span>every mood</span></h2>
                </div>
                <p>Simple ingredients, happy kitchens.<br>Pick a craving and let's get cooking.</p>
            </div>

            <form class="recipe-toolbar" id="recipe-filters" action="{{ route('recipes.index') }}#recipes" method="GET">
                @if ($category !== 'All')<input type="hidden" name="category" value="{{ $category }}">@endif
                @if (request()->boolean('saved'))<input type="hidden" name="saved" value="1">@endif
                <label class="search-box" for="recipe-search">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m16 16 4 4"/></svg>
                    <input id="recipe-search" name="q" type="search" value="{{ $search }}" placeholder="Find a recipe or ingredient..." autocomplete="off">
                    <kbd>/</kbd>
                </label>
                <label class="sort-control" for="recipe-sort"><span>Sort by</span>
                    <select id="recipe-sort" name="sort">
                        <option value="popular" @selected($sort === 'popular')>Most loved</option>
                        <option value="quickest" @selected($sort === 'quickest')>Quickest first</option>
                        <option value="name" @selected($sort === 'name')>A to Z</option>
                    </select>
                </label>
                <button class="search-submit" type="submit">Search</button>
            </form>

            <nav class="category-row" aria-label="Filter recipes by category">
                @foreach (array_merge(['All'], $categories) as $filterCategory)
                    <a class="category-chip {{ $category === $filterCategory ? 'is-active' : '' }}" href="{{ route('recipes.index', array_filter(['category' => $filterCategory === 'All' ? null : $filterCategory, 'q' => $search ?: null, 'sort' => $sort !== 'popular' ? $sort : null, 'saved' => request()->boolean('saved') ? 1 : null])) }}#recipes" @if ($category === $filterCategory) aria-current="page" @endif>
                        @switch($filterCategory)
                            @case('Breakfast')
                                Breakfast
                                @break
                            @case('Lunch')
                                Lunch
                                @break
                            @case('Dinner')
                                Dinner
                                @break
                            @case('Dessert')
                                Desserts
                                @break
                            @case('Snacks')
                                Snacks
                                @break
                            @default
                                All recipes
                        @endswitch
                        @if ($filterCategory === 'All')<span class="chip-count">{{ $recipeCount }}</span>@endif
                    </a>
                @endforeach
            </nav>

            @if (session('status'))<div class="status-message" role="status">{{ session('status') }}</div>@endif
            <div class="results-heading">
                <p><strong>{{ $recipes->total() }}</strong> {{ Illuminate\Support\Str::plural('recipe', $recipes->total()) }} to make something delicious @if (request()->boolean('saved')) <span>· Your saved collection</span> @endif</p>
                @if ($search || $category !== 'All' || request()->boolean('saved'))
                    <a class="clear-filters" href="{{ route('recipes.index') }}#recipes">Clear filters <span>×</span></a>
                @endif
            </div>
            @if ($recipes->isNotEmpty())
                <div class="recipe-grid">
                    @foreach ($recipes as $recipe)
                        @include('recipes.partials.card', ['recipe' => $recipe, 'savedIds' => $savedIds])
                    @endforeach
                </div>
                @if ($recipes->hasPages())
                    <nav class="pagination" aria-label="Recipe pages">
                        @if ($recipes->onFirstPage())<span class="pagination-disabled">← Previous</span>@else<a href="{{ $recipes->previousPageUrl() }}">← Previous</a>@endif
                        <span>Page {{ $recipes->currentPage() }} of {{ $recipes->lastPage() }}</span>
                        @if ($recipes->hasMorePages())<a href="{{ $recipes->nextPageUrl() }}">Next →</a>@else<span class="pagination-disabled">Next →</span>@endif
                    </nav>
                @else
                    <div class="pagination-spacer"></div>
                @endif
            @else
                <div class="empty-state">
                    <span aria-hidden="true">🥄</span>
                    <h3>No recipes on this plate</h3>
                    <p>Try another search or clear your filters to find something tasty.</p>
                    <a class="button button-dark" href="{{ route('recipes.index') }}">Show me everything</a>
                </div>
            @endif
        </section>

        @include('recipes.partials.home-discover')
        <section class="home-tools" aria-labelledby="home-tools-title">
            <div class="home-tools-copy">
                <span class="eyebrow">Make cooking feel easier</span>
                <h2 id="home-tools-title">A little plan. <span>A lot more ease.</span></h2>
                <p>Pick dinners for the week and your shopping list comes together as you go. Need a hand in the kitchen? Our simple guide has you covered.</p>
                <div class="home-tools-actions"><a class="button button-dark" href="{{ route('recipes.planner') }}">Plan my week <span aria-hidden="true">→</span></a><a class="text-link" href="{{ route('recipes.kitchen-guide') }}">Explore the kitchen guide →</a></div>
            </div>
            <div class="home-tools-stats" aria-label="Meal planner benefits"><span>01 <strong>Choose your dinners</strong></span><span>02 <strong>Build your shopping list</strong></span><span>03 <strong>Enjoy a calmer week</strong></span></div>
        </section>
        @include('recipes.partials.home-kitchen-notes')
        @include('recipes.partials.home-story')
        @include('recipes.partials.newsletter')
    </main>

    @include('recipes.partials.footer')
</body>
</html>
