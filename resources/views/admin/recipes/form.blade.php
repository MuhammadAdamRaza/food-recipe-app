<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf8f2">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>{{ $isEditing ? 'Edit recipe' : 'Add a recipe' }} — The Good Table</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}?v=20261005-planner1">
    <script src="{{ asset('js/recipes.js') }}?v=20261005-planner1" defer></script>
</head>
<body>
    @include('recipes.partials.header')
    <main class="admin-form-page">
        <a class="back-link" href="{{ route('admin.recipes.index') }}">← Back to your recipes</a>
        <section class="admin-form-card">
            <span class="eyebrow section-eyebrow">A new favorite is on the way</span>
            <h1>{{ $isEditing ? 'Edit this recipe' : 'Add a recipe' }}</h1>
            <p class="admin-form-intro">A few details are all it takes to put something delicious on the table.</p>
            @if ($errors->any())<div class="form-alert" role="alert"><strong>Almost there. Check the details below.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form class="admin-recipe-form" method="POST" action="{{ $formAction }}" enctype="multipart/form-data">
                @csrf
                @if ($isEditing) @method('PUT') @endif
                @php
                    $ingredientLines = old('ingredients', is_array($recipe->ingredients) ? $recipe->ingredients : ['']);
                    $instructionLines = old('instructions', is_array($recipe->instructions) ? $recipe->instructions : ['']);
                    $ingredientLines = is_array($ingredientLines) && $ingredientLines !== [] ? $ingredientLines : [''];
                    $instructionLines = is_array($instructionLines) && $instructionLines !== [] ? $instructionLines : [''];
                @endphp
                <div class="form-grid">
                    <label class="form-field form-field-wide" for="title">Recipe name<input id="title" name="title" type="text" value="{{ old('title', $recipe->title) }}" maxlength="90" placeholder="e.g. Sunday lemon pasta" required autofocus></label>
                    <label class="form-field" for="category">Category<select id="category" name="category" required>@foreach ($categories as $category)<option value="{{ $category }}" @selected(old('category', $recipe->category) === $category)>{{ $category }}</option>@endforeach</select></label>
                    <label class="form-field" for="cuisine">Cuisine<input id="cuisine" name="cuisine" type="text" value="{{ old('cuisine', $recipe->cuisine) }}" maxlength="40" placeholder="e.g. Italian" required></label>
                    <label class="form-field" for="prep_time">Prep time (minutes)<input id="prep_time" name="prep_time" type="number" min="1" max="1440" value="{{ old('prep_time', $recipe->prep_time) }}" required></label>
                    <label class="form-field" for="cook_time">Cook time (minutes)<input id="cook_time" name="cook_time" type="number" min="0" max="1440" value="{{ old('cook_time', $recipe->cook_time ?? 0) }}" required></label>
                    <label class="form-field" for="servings">Servings<input id="servings" name="servings" type="number" min="1" max="50" value="{{ old('servings', $recipe->servings) }}" required></label>
                    <label class="form-field" for="difficulty">Difficulty<select id="difficulty" name="difficulty" required>@foreach (['Easy', 'Medium', 'Advanced'] as $difficulty)<option value="{{ $difficulty }}" @selected(old('difficulty', $recipe->difficulty) === $difficulty)>{{ $difficulty }}</option>@endforeach</select></label>
                    <div class="form-field form-field-wide">
                        <label for="image_file">Recipe photo <span class="field-optional">optional · JPEG, PNG or WebP · up to 4 MB</span></label>
                        @if ($recipe->exists)<img class="admin-image-preview" src="{{ $recipe->image_src }}" alt="Current photo for {{ $recipe->title }}">@endif
                        <input id="image_file" name="image_file" type="file" accept="image/jpeg,image/png,image/webp" aria-describedby="image-help">
                        <span class="image-help" id="image-help">Uploaded photos are saved locally in <code>public/images/recipes</code>. Leave empty to keep the current photo.</span>
                    </div>
                    <label class="form-field form-field-wide" for="description">A little description<textarea id="description" name="description" rows="2" maxlength="180" placeholder="What makes this recipe special?" required>{{ old('description', $recipe->description) }}</textarea></label>
                    <div class="form-field form-field-wide repeater-field">
                        <span>Ingredients <span class="field-optional">add as many as you need</span></span>
                        <div class="repeater-list" data-repeater-list="ingredients">
                            @foreach ($ingredientLines as $index => $ingredient)
                                <div class="repeater-row">
                                    <label class="visually-hidden" for="ingredient-{{ $index }}">Ingredient {{ $index + 1 }}</label>
                                    <input id="ingredient-{{ $index }}" name="ingredients[]" type="text" value="{{ $ingredient }}" maxlength="500" placeholder="e.g. 2 ripe avocados" required>
                                    <button class="repeater-remove" type="button" aria-label="Remove ingredient {{ $index + 1 }}">×</button>
                                </div>
                            @endforeach
                        </div>
                        <button class="repeater-add" type="button" data-repeater-add="ingredients">＋ Add an ingredient</button>
                    </div>
                    <div class="form-field form-field-wide repeater-field">
                        <span>Instructions <span class="field-optional">one step at a time</span></span>
                        <div class="repeater-list" data-repeater-list="instructions">
                            @foreach ($instructionLines as $index => $instruction)
                                <div class="repeater-row">
                                    <label class="visually-hidden" for="instruction-{{ $index }}">Instruction {{ $index + 1 }}</label>
                                    <textarea id="instruction-{{ $index }}" name="instructions[]" rows="2" maxlength="2000" placeholder="e.g. Preheat the oven..." required>{{ $instruction }}</textarea>
                                    <button class="repeater-remove" type="button" aria-label="Remove step {{ $index + 1 }}">×</button>
                                </div>
                            @endforeach
                        </div>
                        <button class="repeater-add" type="button" data-repeater-add="instructions">＋ Add an instruction</button>
                    </div>
                    <label class="featured-field"><input type="checkbox" name="is_featured" value="1" @checked((bool) old('is_featured', $recipe->is_featured))> Feature this recipe in the homepage hero</label>
                </div>
                <div class="form-actions"><a class="button button-quiet" href="{{ route('admin.recipes.index') }}">Cancel</a><button class="button button-terracotta" type="submit">{{ $isEditing ? 'Save changes' : 'Save recipe' }}</button></div>
            </form>
        </section>
    </main>
    @include('recipes.partials.footer')
</body>
</html>
