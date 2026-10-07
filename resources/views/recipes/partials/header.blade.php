<header class="site-header">
    <a class="brand" href="{{ route('recipes.index') }}" aria-label="The Good Table home">
        <span class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 40 40" fill="none"><path d="M20 4.5c8.56 0 15.5 6.94 15.5 15.5S28.56 35.5 20 35.5 4.5 28.56 4.5 20 11.44 4.5 20 4.5Z" fill="currentColor"/><path d="M13.2 22.7c2.34-5.15 7.33-8.63 13.4-8.88-.66 6.96-4.55 11.62-10.28 12.34-2.38.3-4.22-1.42-3.12-3.46Z" fill="#FBF8F2"/><path d="M13.7 27.8c3.32-4.31 6.72-7.4 11.07-10.35" stroke="#FBF8F2" stroke-width="1.5" stroke-linecap="round"/><path d="M19.12 11.35c.8-2.23 2.58-3.5 4.83-3.66-.12 2.45-1.34 4.11-3.62 4.74" fill="#E98A5A"/></svg>
        </span>
        <span class="brand-name">the good <span>table</span></span>
    </a>
    <button class="mobile-nav-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" aria-label="Open navigation">
        <span></span><span></span>
    </button>
    <nav class="desktop-nav" id="primary-navigation" aria-label="Main navigation">
        <a href="{{ route('recipes.index') }}#recipes" @if (request()->routeIs('recipes.index')) aria-current="page" @endif>Recipes</a>
        <a href="{{ route('recipes.planner') }}" @if (request()->routeIs('recipes.planner')) aria-current="page" @endif>Meal planner</a>
        <a href="{{ route('recipes.kitchen-guide') }}" @if (request()->routeIs('recipes.kitchen-guide')) aria-current="page" @endif>Kitchen guide</a>
        <a href="{{ route('recipes.about') }}" @if (request()->routeIs('recipes.about')) aria-current="page" @endif>About</a>
        <a href="{{ route('recipes.index') }}#newsletter">Newsletter</a>
    </nav>
    <div class="header-actions">
        <a class="icon-button favorites-nav {{ request()->boolean('saved') ? 'is-current' : '' }}" href="{{ route('recipes.index', ['saved' => 1]) }}" aria-label="Show saved recipes">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z"/></svg>
            <span class="favorites-label">Saved</span>
            <span class="favorites-count">{{ count(session('favorite_recipe_ids', [])) }}</span>
        </a>
        @auth
            @if (auth()->user()->is_admin)
                <a class="button button-dark manage-button" href="{{ route('admin.recipes.index') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c.6-3.4 3.3-5.5 7-5.5s6.4 2.1 7 5.5"/></svg><span>Admin dashboard</span></a>
                <form class="header-logout" action="{{ route('admin.logout') }}" method="POST">@csrf<button class="header-logout-button" type="submit" aria-label="Sign out"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 17l5-5-5-5M15 12H3m8-8h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-8"/></svg><span>Sign out</span></button></form>
            @endif
        @else
                <a class="button button-dark manage-button" href="{{ route('admin.login') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c.6-3.4 3.3-5.5 7-5.5s6.4 2.1 7 5.5"/></svg><span>Admin sign in</span></a>
        @endauth
    </div>
</header>
