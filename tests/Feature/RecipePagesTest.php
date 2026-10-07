<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RecipePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_recipe_pages_display_database_recipes(): void
    {
        $recipe = $this->createRecipe();

        $this->get('/')
            ->assertOk()
            ->assertSee($recipe->title)
            ->assertSee('About us')
            ->assertSee('Good recipes leave room for')
            ->assertSee('What sounds good')
            ->assertSee('Good things to know')
            ->assertSee(asset('images/hero-food.jpg'));

        $this->get(route('recipes.show', $recipe))
            ->assertOk()
            ->assertSee($recipe->title)
            ->assertSee('2 ripe tomatoes');

        $this->get(route('recipes.about'))
            ->assertOk()
            ->assertSee('Food tastes better')
            ->assertSee('A few things we')
            ->assertSee('believe.')
            ->assertSee(asset('images/about-kitchen.jpg'))
            ->assertSee('Ingredients you recognize');
    }

    public function test_public_recipe_search_and_category_filters_work(): void
    {
        $lunch = $this->createRecipe(['title' => 'Garden lunch', 'category' => 'Lunch']);
        $this->createRecipe(['title' => 'Midnight pasta', 'category' => 'Dinner']);

        $this->get(route('recipes.index', ['category' => 'Lunch']))
            ->assertOk()
            ->assertSee($lunch->title)
            ->assertSee('category=Lunch#recipes', false)
            ->assertSee('action="' . route('recipes.index') . '#recipes"', false)
            ->assertDontSee('Midnight pasta');

        $this->get(route('recipes.index', ['q' => 'ripe tomatoes']))
            ->assertOk()
            ->assertSee($lunch->title);
    }

    public function test_homepage_has_recipe_discovery_and_kitchen_tips_sections(): void
    {
        $this->createRecipe();

        $this->get('/')
            ->assertOk()
            ->assertSee('What sounds good')
            ->assertSee('Something sweet')
            ->assertSee('Good things to know')
            ->assertSee('Taste as you go');
    }

    public function test_visitors_can_save_a_recipe_to_their_session(): void
    {
        $recipe = $this->createRecipe();

        $this->post(route('recipes.favorite', $recipe))
            ->assertRedirect()
            ->assertSessionHas('favorite_recipe_ids', [$recipe->id]);

        $this->get(route('recipes.index', ['saved' => 1]))
            ->assertOk()
            ->assertSee($recipe->title);

        $this->post(route('recipes.favorite', $recipe))
            ->assertRedirect()
            ->assertSessionHas('favorite_recipe_ids', []);
    }

    public function test_recipe_management_requires_a_real_administrator_account(): void
    {
        $this->get(route('admin.recipes.index'))
            ->assertRedirect(route('admin.login'));

        $user = $this->createUser();

        $this->actingAs($user)
            ->get(route('admin.recipes.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_filter_categories_and_add_recipe_steps(): void
    {
        $admin = $this->createUser(['is_admin' => true]);
        $lunch = $this->createRecipe(['title' => 'Lunch bowl', 'category' => 'Lunch']);
        $this->createRecipe(['title' => 'Evening pasta', 'category' => 'Dinner']);

        $this->actingAs($admin)
            ->get(route('admin.recipes.index', ['category' => 'Lunch']))
            ->assertOk()
            ->assertSee($lunch->title)
            ->assertDontSee('Evening pasta');

        $this->get(route('admin.recipes.create'))
            ->assertOk()
            ->assertSee('name="ingredients[]"', false)
            ->assertSee('data-repeater-add="ingredients"', false)
            ->assertSee('name="instructions[]"', false)
            ->assertSee('data-repeater-add="instructions"', false);
    }

    public function test_administrator_can_sign_in_and_create_edit_and_delete_recipes(): void
    {
        $admin = $this->createUser(['is_admin' => true]);
        $recipe = $this->createRecipe();

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'GoodPassword!123',
        ])->assertRedirect(route('admin.recipes.index'));

        $this->get(route('admin.recipes.index'))
            ->assertOk()
            ->assertSee($recipe->title);

        $this->post(route('admin.recipes.store'), $this->recipePayload(['title' => 'New pasta']))
            ->assertRedirect(route('admin.recipes.index'));

        $created = Recipe::query()->where('title', 'New pasta')->firstOrFail();
        $this->assertSame(['1 cup flour', '2 ripe tomatoes'], $created->ingredients);

        $this->put(route('admin.recipes.update', $created), $this->recipePayload(['title' => 'Updated pasta']))
            ->assertRedirect(route('admin.recipes.index'));
        $this->assertDatabaseHas('recipes', ['id' => $created->id, 'title' => 'Updated pasta']);

        $created->refresh();
        $this->delete(route('admin.recipes.destroy', $created))
            ->assertRedirect(route('admin.recipes.index'));
        $this->assertDatabaseMissing('recipes', ['id' => $created->id]);
    }

    public function test_admin_login_rejects_non_admin_accounts(): void
    {
        $user = $this->createUser();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'GoodPassword!123',
        ])->assertSessionHasErrors('email');
    }

    public function test_admin_saves_and_deletes_recipe_photos_in_the_public_images_folder(): void
    {
        $admin = $this->createUser(['is_admin' => true]);
        $this->actingAs($admin);
        $payload = $this->recipePayload();
        $payload['image_file'] = UploadedFile::fake()->image('recipe.jpg');

        $this->post(route('admin.recipes.store'), $payload)
            ->assertRedirect(route('admin.recipes.index'));

        $recipe = Recipe::query()->where('title', 'Fresh tomato pasta')->firstOrFail();
        $this->assertStringStartsWith('images/recipes/', $recipe->image_url);
        $this->assertFileExists(public_path($recipe->image_url));

        $imagePath = public_path($recipe->image_url);

        $this->delete(route('admin.recipes.destroy', $recipe))
            ->assertRedirect(route('admin.recipes.index'));

        $this->assertFileDoesNotExist($imagePath);
    }

    private function createRecipe(array $overrides = []): Recipe
    {
        $attributes = [
            ...$this->recipePayload(),
            'slug' => 'fresh-tomato-pasta-' . uniqid(),
            ...$overrides,
        ];

        $attributes['ingredients'] = is_array($attributes['ingredients'])
            ? $attributes['ingredients']
            : array_filter(array_map('trim', explode("\n", $attributes['ingredients'])));
        $attributes['instructions'] = is_array($attributes['instructions'])
            ? $attributes['instructions']
            : array_filter(array_map('trim', explode("\n", $attributes['instructions'])));

        return Recipe::query()->create($attributes);
    }

    private function recipePayload(array $overrides = []): array
    {
        return [
            'title' => 'Fresh tomato pasta',
            'slug' => 'fresh-tomato-pasta',
            'category' => 'Dinner',
            'cuisine' => 'Italian',
            'description' => 'A simple, bright tomato supper.',
            'image_url' => null,
            'prep_time' => 10,
            'cook_time' => 20,
            'servings' => 2,
            'difficulty' => 'Easy',
            'ingredients' => ['1 cup flour', '2 ripe tomatoes'],
            'instructions' => ['Cook the pasta.', 'Add the tomatoes.'],
            'is_featured' => false,
            ...$overrides,
        ];
    }

    private function createUser(array $overrides = []): User
    {
        return User::query()->forceCreate([
            'name' => 'Recipe Editor',
            'email' => 'editor-' . uniqid() . '@example.com',
            'password' => Hash::make('GoodPassword!123'),
            'is_admin' => false,
            ...$overrides,
        ]);
    }
}
