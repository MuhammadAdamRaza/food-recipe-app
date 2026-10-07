<footer class="site-footer" id="about">
    <a class="brand footer-brand" href="{{ route('recipes.index') }}">
        <span class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 40 40" fill="none"><path d="M20 4.5c8.56 0 15.5 6.94 15.5 15.5S28.56 35.5 20 35.5 4.5 28.56 4.5 20 11.44 4.5 20 4.5Z" fill="currentColor"/><path d="M13.2 22.7c2.34-5.15 7.33-8.63 13.4-8.88-.66 6.96-4.55 11.62-10.28 12.34-2.38.3-4.22-1.42-3.12-3.46Z" fill="#FBF8F2"/><path d="M13.7 27.8c3.32-4.31 6.72-7.4 11.07-10.35" stroke="#FBF8F2" stroke-width="1.5" stroke-linecap="round"/><path d="M19.12 11.35c.8-2.23 2.58-3.5 4.83-3.66-.12 2.45-1.34 4.11-3.62 4.74" fill="#E98A5A"/></svg>
        </span>
        <span class="brand-name">the good <span>table</span></span>
    </a>
    <p>Pull up a chair. There's always room at our table.</p>
    <nav class="footer-nav" aria-label="Footer navigation">
        <a href="{{ route('recipes.index') }}#recipes">Recipes</a>
        <a href="{{ route('recipes.planner') }}">Meal planner</a>
        <a href="{{ route('recipes.kitchen-guide') }}">Kitchen guide</a>
        <a href="{{ route('recipes.about') }}">About</a>
    </nav>
    <span class="footer-credit">Made for sharing <span>♥</span></span>
</footer>
