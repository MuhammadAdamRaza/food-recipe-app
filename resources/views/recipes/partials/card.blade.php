<article class="recipe-card">
    <div class="card-image-wrap">
        <a href="{{ route('recipes.show', $recipe) }}" aria-label="View {{ $recipe->title }}">
            <img class="card-image" src="{{ $recipe->image_src }}" alt="{{ $recipe->title }}" loading="lazy">
        </a>
        <span class="card-category">{{ $recipe->category }}</span>
        <form class="card-favorite-form" method="POST" action="{{ route('recipes.favorite', $recipe) }}">@csrf
            <button class="favorite-button" type="submit" aria-pressed="{{ in_array($recipe->id, $savedIds, true) ? 'true' : 'false' }}" aria-label="{{ in_array($recipe->id, $savedIds, true) ? 'Remove '.$recipe->title.' from saved recipes' : 'Save '.$recipe->title }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z"/></svg>
            </button>
        </form>
    </div>
    <div class="card-body">
        <div class="card-meta"><span>{{ $recipe->cuisine }}</span><span class="card-rating"><span aria-hidden="true">★</span> {{ $recipe->rating }} <span class="card-difficulty">· {{ $recipe->difficulty }}</span></span></div>
        <h3 class="card-title"><a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a></h3>
        <p class="card-description">{{ $recipe->description }}</p>
        <div class="card-footer">
            <span class="card-time"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>{{ $recipe->total_time }} min</span>
            <a class="card-action" href="{{ route('recipes.show', $recipe) }}">Get cooking <span aria-hidden="true">→</span></a>
        </div>
    </div>
</article>
