<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf8f2">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Admin sign in — The Good Table</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}">
</head>
<body class="admin-body">
    <main class="auth-page">
        <a class="brand auth-brand" href="{{ route('recipes.index') }}"><span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 40 40" fill="none"><path d="M20 4.5c8.56 0 15.5 6.94 15.5 15.5S28.56 35.5 20 35.5 4.5 28.56 4.5 20 11.44 4.5 20 4.5Z" fill="currentColor"/><path d="M13.2 22.7c2.34-5.15 7.33-8.63 13.4-8.88-.66 6.96-4.55 11.62-10.28 12.34-2.38.3-4.22-1.42-3.12-3.46Z" fill="#FBF8F2"/></svg></span><span class="brand-name">the good <span>table</span></span></a>
        <section class="auth-card">
            <span class="eyebrow section-eyebrow">For the people behind the recipes</span>
            <h1>Welcome <span>back.</span></h1>
            <p>Sign in with your administrator account to manage the recipe collection.</p>
            @if (session('error'))<div class="form-alert" role="alert">{{ session('error') }}</div>@endif
            @if ($errors->any())<div class="form-alert" role="alert">{{ $errors->first() }}</div>@endif
            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf
                <label class="form-field" for="email">Email address<input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus></label>
                <label class="form-field" for="password">Password<input id="password" name="password" type="password" autocomplete="current-password" required></label>
                <label class="remember-field"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
                <button class="button button-dark auth-submit" type="submit">Sign in to the kitchen <span aria-hidden="true">→</span></button>
            </form>
            <a class="auth-back" href="{{ route('recipes.index') }}">← Back to the recipes</a>
        </section>
        <p class="auth-caption">A little care goes a long way.</p>
    </main>
</body>
</html>
