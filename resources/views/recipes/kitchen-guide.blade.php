<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf8f2">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="description" content="Friendly kitchen tips for easier prep, better seasoning, and more relaxed everyday cooking.">
    <title>Kitchen guide — The Good Table</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}?v=20261005-planner1">
    <script src="{{ asset('js/recipes.js') }}?v=20261005-planner1" defer></script>
</head>
<body>
    @include('recipes.partials.header')
    <main class="tool-page guide-page">
        <section class="tool-hero guide-hero">
            <span class="eyebrow"><span class="eyebrow-dot"></span> A little help along the way</span>
            <h1>Feel more at home <span>in your kitchen.</span></h1>
            <p>Small, useful habits for smoother prep, tastier meals, and less guesswork at the stove.</p>
            <a class="button button-terracotta" href="{{ route('recipes.index') }}#recipes">Find a recipe to try <span aria-hidden="true">→</span></a>
        </section>

        <section class="guide-feature-grid" aria-label="Everyday cooking tips">
            <article class="guide-feature"><span class="guide-number">01</span><span class="guide-icon" aria-hidden="true">✳</span><h2>Set yourself up first</h2><p>Read the whole recipe, clear a little counter space, and get out the tools you need. Chop and measure before the pan gets hot.</p><ul><li>Check the oven temperature and cooking time.</li><li>Keep a small bowl nearby for scraps.</li><li>Put ingredients back as you use them.</li></ul></article>
            <article class="guide-feature"><span class="guide-number">02</span><span class="guide-icon" aria-hidden="true">⌁</span><h2>Build flavor as you go</h2><p>Season in layers instead of adding everything at the end. Taste once the ingredients have had a chance to cook together.</p><ul><li>Start with a little salt; add more after tasting.</li><li>A squeeze of lemon can brighten a rich dish.</li><li>Fresh herbs are lovely added just before serving.</li></ul></article>
            <article class="guide-feature"><span class="guide-number">03</span><span class="guide-icon" aria-hidden="true">◷</span><h2>Make time work for you</h2><p>Use the quiet moments while something simmers or roasts to tidy up, set the table, or prepare the next step.</p><ul><li>Set a timer when a recipe gives a time range.</li><li>Use visual cues as well as the clock.</li><li>Let meat rest before slicing so it stays juicy.</li></ul></article>
            <article class="guide-feature"><span class="guide-number">04</span><span class="guide-icon" aria-hidden="true">♡</span><h2>Make the recipe yours</h2><p>Swap ingredients thoughtfully and trust your taste. Everyday cooking is more joyful when you can work with what you have.</p><ul><li>Use a similar vegetable when one is out of season.</li><li>Keep the same basic proportions for dressings.</li><li>Write down the little changes you loved.</li></ul></article>
        </section>

        <section class="pantry-guide">
            <div><span class="eyebrow section-eyebrow">A helpful little backup</span><h2>A few pantry staples go <span>a long way.</span></h2><p>Keeping a handful of versatile basics nearby makes it easier to turn fresh ingredients into dinner.</p><a class="button button-dark" href="{{ route('recipes.planner') }}">Plan dinners for the week</a></div>
            <ul class="pantry-list"><li><span>01</span> Olive oil and a neutral cooking oil</li><li><span>02</span> Kosher salt, black pepper, and chili flakes</li><li><span>03</span> Garlic, onions, and lemons</li><li><span>04</span> Rice, pasta, or another favorite grain</li><li><span>05</span> Canned beans, tomatoes, or stock</li><li><span>06</span> Vinegar and a little something sweet</li></ul>
        </section>

        <section class="guide-closing"><span class="eyebrow">Ready when you are</span><h2>Good cooking starts with <span>one small step.</span></h2><p>Pick something that sounds delicious. We’ll meet you in the recipe.</p><a class="button button-terracotta" href="{{ route('recipes.index') }}#recipes">Explore all recipes <span aria-hidden="true">→</span></a></section>
    </main>
    @include('recipes.partials.newsletter')
    @include('recipes.partials.footer')
</body>
</html>
