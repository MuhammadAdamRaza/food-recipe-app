<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [
            [
                'title' => 'Crispy chickpea bowl',
                'category' => 'Lunch',
                'cuisine' => 'Mediterranean',
                'description' => 'Golden, crunchy chickpeas meet cool cucumber and the dreamiest lemon tahini.',
                'image_url' => 'images/salad-bowl.jpg',
                'prep_time' => 10,
                'cook_time' => 15,
                'servings' => 2,
                'difficulty' => 'Easy',
                'rating' => 4.9,
                'ingredients' => ['1 can chickpeas, drained and dried', '1 tsp smoked paprika', '2 tbsp olive oil', '1 cucumber, sliced', '2 cups leafy greens', '3 tbsp tahini', '1 lemon, juiced'],
                'instructions' => ['Heat the oven to 220°C (425°F). Toss the chickpeas with olive oil, paprika, and a pinch of salt.', 'Roast on a tray for 20 minutes, shaking halfway, until golden and crisp.', 'Whisk the tahini with lemon juice and a splash of water until silky.', 'Divide the greens and cucumber between bowls. Add the warm chickpeas and drizzle generously with tahini.'],
                'is_featured' => true,
            ],
            [
                'title' => 'Strawberry ricotta toast',
                'category' => 'Breakfast',
                'cuisine' => 'Modern',
                'description' => 'Whipped ricotta, ripe berries, and a little honey on very good toast.',
                'image_url' => 'images/strawberry-toast.jpg',
                'prep_time' => 10,
                'cook_time' => 0,
                'servings' => 2,
                'difficulty' => 'Easy',
                'rating' => 4.8,
                'ingredients' => ['2 thick slices sourdough', '½ cup ricotta', '1 cup ripe strawberries, sliced', '1 tbsp honey', 'Fresh mint leaves', 'A pinch of flaky salt'],
                'instructions' => ['Toast the sourdough until deeply golden at the edges.', 'Spread each slice with a generous layer of ricotta.', 'Pile on the strawberries, drizzle with honey, and finish with mint and flaky salt.'],
            ],
            [
                'title' => 'Lemony orzo skillet',
                'category' => 'Dinner',
                'cuisine' => 'Italian',
                'description' => 'A one-pan bowl of buttery orzo, bright lemon, and heaps of fresh herbs.',
                'image_url' => 'images/lemon-orzo.jpg',
                'prep_time' => 10,
                'cook_time' => 20,
                'servings' => 4,
                'difficulty' => 'Easy',
                'rating' => 5.0,
                'ingredients' => ['1 tbsp olive oil', '1 small shallot, finely chopped', '1½ cups orzo', '3 cups vegetable stock', '1 lemon, zest and juice', '½ cup grated parmesan', 'A handful of fresh parsley'],
                'instructions' => ['Warm the oil in a wide pan over medium heat and soften the shallot for 3 minutes.', 'Add the orzo and stir to coat. Pour in the stock and simmer, stirring now and then, until tender.', 'Stir in the lemon zest, juice, and parmesan. Add a splash of water if it looks too thick.', 'Finish with chopped parsley, black pepper, and extra parmesan. Bring the pan to the table.'],
            ],
            [
                'title' => 'Peach yogurt pancakes',
                'category' => 'Breakfast',
                'cuisine' => 'American',
                'description' => 'Fluffy little stacks with juicy peaches and a spoonful of maple yogurt.',
                'image_url' => 'images/peach-pancakes.jpg',
                'prep_time' => 10,
                'cook_time' => 10,
                'servings' => 3,
                'difficulty' => 'Easy',
                'rating' => 4.9,
                'ingredients' => ['1 cup all-purpose flour', '1 tsp baking powder', '¾ cup Greek yogurt', '1 egg', '½ cup milk', '2 ripe peaches, sliced', 'Maple syrup, for serving'],
                'instructions' => ['Whisk the flour and baking powder in a bowl. In a second bowl, whisk the yogurt, egg, and milk.', 'Fold the wet ingredients into the dry just until combined. A few lumps are just right.', 'Cook spoonfuls of batter on a lightly buttered warm skillet until bubbles appear, then flip.', 'Serve warm with sliced peaches, maple syrup, and an extra dollop of yogurt.'],
            ],
            [
                'title' => 'Tomato & burrata pasta',
                'category' => 'Dinner',
                'cuisine' => 'Italian',
                'description' => 'Jammy tomatoes, garlicky olive oil, and the burrata you saved for a special day.',
                'image_url' => 'images/tomato-pasta.jpg',
                'prep_time' => 10,
                'cook_time' => 25,
                'servings' => 4,
                'difficulty' => 'Easy',
                'rating' => 4.9,
                'ingredients' => ['350 g rigatoni', '3 tbsp olive oil', '4 cloves garlic, thinly sliced', '500 g cherry tomatoes', '½ tsp chili flakes', '2 balls burrata', 'Fresh basil leaves'],
                'instructions' => ['Cook the pasta in well-salted water until just al dente. Save a mug of pasta water.', 'Gently warm the olive oil and garlic in a wide pan. Add the tomatoes and chili flakes.', 'Cook for 12–15 minutes, stirring, until the tomatoes burst into a glossy sauce.', 'Toss the pasta with the sauce and a splash of pasta water. Tear over the burrata and basil.'],
            ],
            [
                'title' => 'Green goddess salad',
                'category' => 'Lunch',
                'cuisine' => 'California',
                'description' => 'Crunchy greens, creamy avocado, and a punchy herby dressing worth making extra.',
                'image_url' => 'images/green-goddess-salad.jpg',
                'prep_time' => 15,
                'cook_time' => 0,
                'servings' => 2,
                'difficulty' => 'Easy',
                'rating' => 4.7,
                'ingredients' => ['1 small romaine heart, chopped', '½ small green cabbage, chopped', '1 cucumber, diced', '1 avocado, sliced', '½ cup Greek yogurt', '1 lemon, juiced', '1 cup mixed soft herbs'],
                'instructions' => ['Add the yogurt, lemon juice, herbs, and a pinch of salt to a blender. Blend until bright green and smooth.', 'Toss the romaine, cabbage, and cucumber in a large bowl.', 'Add the avocado, dress generously, and serve with crusty bread.'],
            ],
            [
                'title' => 'Brown butter cookies',
                'category' => 'Dessert',
                'cuisine' => 'American',
                'description' => 'Crisp edges, soft middles, pools of chocolate, and absolutely no leftovers.',
                'image_url' => 'images/brown-butter-cookies.jpg',
                'prep_time' => 25,
                'cook_time' => 15,
                'servings' => 12,
                'difficulty' => 'Easy',
                'rating' => 5.0,
                'ingredients' => ['170 g unsalted butter', '¾ cup brown sugar', '¼ cup caster sugar', '1 egg plus 1 yolk', '1 tsp vanilla extract', '1¾ cups plain flour', '150 g dark chocolate, chopped'],
                'instructions' => ['Melt the butter in a small pan and cook until nutty and golden. Let it cool for 10 minutes.', 'Whisk both sugars into the butter, then add the egg, yolk, and vanilla.', 'Fold in the flour and chopped chocolate. Chill the dough for 20 minutes.', 'Scoop onto a lined tray and bake at 180°C (350°F) for 10–12 minutes. Sprinkle with sea salt.'],
            ],
            [
                'title' => 'Crispy potato tacos',
                'category' => 'Dinner',
                'cuisine' => 'Mexican',
                'description' => 'Smoky golden potatoes, zingy lime crema, and a pile of pickled red onions.',
                'image_url' => 'images/potato-tacos.jpg',
                'prep_time' => 10,
                'cook_time' => 20,
                'servings' => 4,
                'difficulty' => 'Easy',
                'rating' => 4.8,
                'ingredients' => ['500 g baby potatoes, halved', '1 tsp ground cumin', '1 tsp smoked paprika', '8 small corn tortillas', '½ cup sour cream', '1 lime, juiced', 'Quick-pickled red onion, to serve'],
                'instructions' => ['Toss the potatoes with olive oil, cumin, paprika, and salt. Roast at 220°C (425°F) until crisp.', 'Stir the sour cream with lime juice and a pinch of salt.', 'Warm the tortillas in a dry pan until soft and lightly toasted.', 'Fill each tortilla with potatoes, lime crema, and lots of pickled red onion.'],
            ],
            [
                'title' => 'Blueberry crumb cake',
                'category' => 'Dessert',
                'cuisine' => 'American',
                'description' => 'A tender, buttery afternoon cake hiding jammy pockets of blueberry.',
                'image_url' => 'images/blueberry-crumb-cake.jpg',
                'prep_time' => 10,
                'cook_time' => 40,
                'servings' => 8,
                'difficulty' => 'Easy',
                'rating' => 4.9,
                'ingredients' => ['1½ cups all-purpose flour', '¾ cup sugar', '1 tsp baking powder', '½ cup softened butter', '2 eggs', '½ cup plain yogurt', '1½ cups blueberries'],
                'instructions' => ['Heat the oven to 180°C (350°F). Butter and line a small cake tin.', 'Cream the butter and sugar until fluffy. Beat in the eggs one at a time.', 'Fold in the flour and baking powder, followed by the yogurt and most of the blueberries.', 'Scatter over the remaining berries and bake for 35–40 minutes, until a tester comes out clean.'],
            ],
        ];

        foreach ($recipes as $recipe) {
            Recipe::query()->updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($recipe['title'])],
                [...$recipe, 'slug' => \Illuminate\Support\Str::slug($recipe['title'])],
            );
        }
    }
}

