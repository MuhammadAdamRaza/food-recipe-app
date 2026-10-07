<section class="home-discover" aria-labelledby="home-discover-title">
    <div class="section-heading">
        <div>
            <span class="eyebrow section-eyebrow">A table for every craving</span>
            <h2 id="home-discover-title">What sounds good <span>today?</span></h2>
        </div>
        <p>Pick a moment, find a recipe,<br>and make it your own.</p>
    </div>
    <div class="mood-grid">
        <a class="mood-card" href="{{ route('recipes.index', ['category' => 'Breakfast']) }}#recipes">
            <img src="{{ asset('images/strawberry-toast.jpg') }}" alt="" loading="lazy">
            <span class="mood-card-shade"></span>
            <span class="mood-card-copy"><span>Start the day</span><strong>Breakfast</strong></span>
            <span class="mood-card-arrow" aria-hidden="true">→</span>
        </a>
        <a class="mood-card" href="{{ route('recipes.index', ['category' => 'Lunch']) }}#recipes">
            <img src="{{ asset('images/green-goddess-salad.jpg') }}" alt="" loading="lazy">
            <span class="mood-card-shade"></span>
            <span class="mood-card-copy"><span>A midday favorite</span><strong>Lunch</strong></span>
            <span class="mood-card-arrow" aria-hidden="true">→</span>
        </a>
        <a class="mood-card" href="{{ route('recipes.index', ['category' => 'Dinner']) }}#recipes">
            <img src="{{ asset('images/tomato-pasta.jpg') }}" alt="" loading="lazy">
            <span class="mood-card-shade"></span>
            <span class="mood-card-copy"><span>Gather around</span><strong>Dinner</strong></span>
            <span class="mood-card-arrow" aria-hidden="true">→</span>
        </a>
        <a class="mood-card" href="{{ route('recipes.index', ['category' => 'Dessert']) }}#recipes">
            <img src="{{ asset('images/brown-butter-cookies.jpg') }}" alt="" loading="lazy">
            <span class="mood-card-shade"></span>
            <span class="mood-card-copy"><span>Save room for</span><strong>Something sweet</strong></span>
            <span class="mood-card-arrow" aria-hidden="true">→</span>
        </a>
    </div>
</section>
