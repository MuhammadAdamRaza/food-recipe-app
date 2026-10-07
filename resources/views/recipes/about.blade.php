<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf8f2">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="description" content="Learn what The Good Table is all about: approachable recipes, a practical meal planner, and friendly kitchen tips.">
    <title>About The Good Table</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}?v=20261005-planner1">
    <script src="{{ asset('js/recipes.js') }}?v=20261005-planner1" defer></script>
</head>
<body>
    @include('recipes.partials.header')
    <main>
        <section class="about-hero">
            <div class="about-hero-copy">
                <span class="eyebrow"><span class="eyebrow-dot"></span> Pull up a chair</span>
                <h1>Everyday cooking, <span>made warmer.</span></h1>
                <p>The Good Table helps you find something delicious to make, plan a week of easy dinners, and feel more at home in your kitchen. Good food can be simple, joyful, and made for sharing.</p>
                <div class="about-hero-actions">
                    <a class="button button-terracotta" href="{{ route('recipes.index') }}#recipes">Explore the recipes</a>
                    <a class="text-link" href="{{ route('recipes.planner') }}">Plan this week →</a>
                </div>
            </div>
            <div class="about-hero-art">
                <img src="{{ asset('images/about-kitchen.jpg') }}" alt="A dinner table set for sharing with fresh food and warm lighting">
                <span class="about-image-note">Made for sharing.</span>
            </div>
        </section>

        <section class="about-story">
            <div>
                <span class="eyebrow section-eyebrow">A little about us</span>
                <h2>A good meal can make an ordinary day <span>feel special.</span></h2>
            </div>
            <div class="about-story-text">
                <p>The Good Table is a place for approachable recipes with clear steps, familiar ingredients, and plenty of room to make each dish your own. Whether you have a little time or a table full of friends, there is always something good to cook.</p>
                <p>We also want the rest of cooking to feel easier. Save recipes for later, use the meal planner to build a shopping list, or visit the kitchen guide for small tips that make a big difference.</p>
            </div>
        </section>

        <section class="about-way">
            <div class="about-way-heading">
                <span class="eyebrow section-eyebrow">A few good things to explore</span>
                <h2>Everything you need for a more <span>delicious week.</span></h2>
                <p>Find a new favorite, make a simple plan, and enjoy the time around the table.</p>
            </div>
            <div class="about-way-grid">
                <article>
                    <span class="about-way-number">01</span>
                    <h3>Recipes for real life</h3>
                    <p>Browse by meal, search for an ingredient, and save recipes you want to make again.</p>
                    <a class="about-card-link" href="{{ route('recipes.index') }}#recipes">Browse recipes <span aria-hidden="true">→</span></a>
                </article>
                <article>
                    <span class="about-way-number">02</span>
                    <h3>A plan that comes together</h3>
                    <p>Choose dinners for the week and gather the ingredients in one handy shopping list.</p>
                    <a class="about-card-link" href="{{ route('recipes.planner') }}">Open the meal planner <span aria-hidden="true">→</span></a>
                </article>
                <article>
                    <span class="about-way-number">03</span>
                    <h3>Friendly kitchen guidance</h3>
                    <p>Pick up simple ideas for easier prep, better seasoning, and less guesswork.</p>
                    <a class="about-card-link" href="{{ route('recipes.kitchen-guide') }}">Visit the kitchen guide <span aria-hidden="true">→</span></a>
                </article>
            </div>
        </section>

        <section class="about-values">
            <div class="about-values-heading">
                <span class="eyebrow section-eyebrow">Our little philosophy</span>
                <h2>Keep cooking <span>joyful.</span></h2>
            </div>
            <div class="values-grid">
                <article class="value-card">
                    <span class="value-icon" aria-hidden="true">🌿</span>
                    <h3>Honor the seasons</h3>
                    <p>Fresh, seasonal ingredients bring color and flavor to even the simplest meals.</p>
                </article>
                <article class="value-card">
                    <span class="value-icon" aria-hidden="true">🫶</span>
                    <h3>Cooking is personal</h3>
                    <p>Use what you have, taste as you go, and make every recipe work for your table.</p>
                </article>
                <article class="value-card">
                    <span class="value-icon" aria-hidden="true">🍽️</span>
                    <h3>Always make room</h3>
                    <p>Make space for the people, conversations, and second helpings that make a meal memorable.</p>
                </article>
            </div>
        </section>

        <section class="about-invite">
            <img src="{{ asset('images/fresh-ingredients.jpg') }}" alt="A beautiful arrangement of fresh ingredients ready to become dinner">
            <div>
                <span class="eyebrow">Your next good meal</span>
                <h2>Make room for <span>something delicious.</span></h2>
                <p>Choose a recipe for tonight, or plan a few dinners ahead and make the week feel easier.</p>
                <div class="about-hero-actions"><a class="button button-dark" href="{{ route('recipes.index') }}#recipes">Find a recipe</a><a class="text-link" href="{{ route('recipes.planner') }}">Plan my week →</a></div>
            </div>
        </section>

        @include('recipes.partials.newsletter')
    </main>
    @include('recipes.partials.footer')
</body>
</html>
