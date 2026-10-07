<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf8f2">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="description" content="Plan a week of dinners and build a handy shopping list with recipes from The Good Table.">
    <title>Meal planner — The Good Table</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}?v=20261005-planner1">
    <script src="{{ asset('js/recipes.js') }}?v=20261005-planner1" defer></script>
</head>
<body>
    @include('recipes.partials.header')
    <main class="tool-page planner-page" data-meal-planner>
        <section class="tool-hero">
            <span class="eyebrow"><span class="eyebrow-dot"></span> A calmer week starts here</span>
            <h1>Make a little room for <span>good dinners.</span></h1>
            <p>Choose a dinner for each day. Your plan and shopping list save in this browser as you go.</p>
            <div class="planner-progress"><span data-planner-progress>0 of 7 dinners planned</span><span class="planner-progress-track"><span data-planner-progress-bar></span></span></div>
        </section>

        <section class="planner-layout" aria-label="Weekly dinner planner">
            <div class="planner-card">
                <div class="tool-card-heading"><div><span class="eyebrow section-eyebrow">Your week at a glance</span><h2>Pick your dinners</h2></div><button class="text-button" type="button" data-planner-clear>Clear week</button></div>
                <div class="planner-days">
                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        <label class="planner-day" for="planner-{{ strtolower($day) }}">
                            <span class="planner-day-name">{{ $day }}</span>
                            <select id="planner-{{ strtolower($day) }}" data-planner-day="{{ $day }}">
                                <option value="">Choose a recipe…</option>
                                @foreach ($recipes as $recipe)
                                    <option value="{{ $recipe->id }}">{{ $recipe->title }} · {{ $recipe->total_time }} min</option>
                                @endforeach
                            </select>
                        </label>
                    @endforeach
                </div>
            </div>

            <aside class="shopping-card" aria-labelledby="shopping-list-title">
                <div class="tool-card-heading"><div><span class="eyebrow section-eyebrow">Everything in one place</span><h2 id="shopping-list-title">Shopping list</h2></div><span class="shopping-count" data-shopping-count>0</span></div>
                <p class="shopping-hint" data-shopping-hint>Choose a few dinners to see what you’ll need.</p>
                <ul class="shopping-list" data-shopping-list aria-live="polite"></ul>
                <div class="shopping-actions"><button class="button button-dark" type="button" data-print-list>Print list</button><button class="button button-quiet" type="button" data-copy-list>Copy list</button></div>
                <p class="planner-feedback" data-planner-feedback role="status"></p>
            </aside>
        </section>

        <section class="planner-tip"><span aria-hidden="true">✳</span><p><strong>A little flexibility goes a long way.</strong> Leave a night open for leftovers, a last-minute plan, or whatever looks good at the market.</p><a class="text-link" href="{{ route('recipes.kitchen-guide') }}">Kitchen tips →</a></section>
        <script type="application/json" data-planner-recipes>@json($recipes->map(fn ($recipe) => ['id' => (string) $recipe->id, 'title' => $recipe->title, 'ingredients' => $recipe->ingredients])->values())</script>
    </main>
    @include('recipes.partials.newsletter')
    @include('recipes.partials.footer')
</body>
</html>
