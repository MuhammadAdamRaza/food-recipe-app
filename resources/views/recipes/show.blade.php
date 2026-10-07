<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf8f2">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="description" content="{{ $recipe->description }}">
    <title>{{ $recipe->title }} — The Good Table</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}?v=20261005-planner1">
    <script src="{{ asset('js/recipes.js') }}?v=20261005-planner1" defer></script>
</head>
<body>
    @include('recipes.partials.header')
    <main class="detail-page">
        <a class="back-link" href="{{ route('recipes.index') }}">← Back to all recipes</a>
        @if (session('status'))<div class="status-message" role="status">{{ session('status') }}</div>@endif
        <article class="recipe-detail-page">
            <div class="detail-page-image">
                <img src="{{ $recipe->image_src }}" alt="{{ $recipe->title }}">
                <span class="detail-image-category">{{ $recipe->category }}</span>
            </div>
            <div class="detail-page-content">
                <div class="detail-topline"><span>{{ $recipe->cuisine }}</span><span>◷ {{ $recipe->total_time }} minutes</span><span>◎ Serves {{ $recipe->servings }}</span><span>★ {{ $recipe->rating }}</span><span>{{ $recipe->difficulty }}</span></div>
                <div class="detail-title-row">
                    <div><h1>{{ $recipe->title }}</h1><p class="detail-description">{{ $recipe->description }}</p></div>
                    <form method="POST" action="{{ route('recipes.favorite', $recipe) }}">@csrf<button class="button button-quiet" type="submit">{{ in_array($recipe->id, $savedIds, true) ? '♥ Saved' : '♡ Save recipe' }}</button></form>
                </div>
                <div class="detail-columns">
                    <section><h2>What you'll need</h2><ul class="detail-ingredient-list">@foreach ($recipe->ingredients as $ingredient)<li>{{ $ingredient }}</li>@endforeach</ul></section>
                    <section><h2>Let's make it</h2><ol class="detail-instruction-list">@foreach ($recipe->instructions as $instruction)<li>{{ $instruction }}</li>@endforeach</ol></section>
                </div>
            </div>
        </article>
        @if ($relatedRecipes->isNotEmpty())
            <section class="related-section"><div class="section-heading"><div><span class="eyebrow section-eyebrow">Good things go together</span><h2>More {{ Illuminate\Support\Str::lower($recipe->category) }} <span>favorites</span></h2></div><a class="text-link" href="{{ route('recipes.index', ['category' => $recipe->category]) }}">See all {{ Illuminate\Support\Str::lower($recipe->category) }} recipes →</a></div>
                <div class="recipe-grid">@foreach ($relatedRecipes as $relatedRecipe)@include('recipes.partials.card', ['recipe' => $relatedRecipe, 'savedIds' => $savedIds])@endforeach</div>
            </section>

            @endif
        @include('recipes.partials.newsletter')
<a href="{{ route('recipes.index') }}" class="text-link">← Back to all recipes</a>

    </main>
    @include('recipes.partials.footer')
</body>
</html>
