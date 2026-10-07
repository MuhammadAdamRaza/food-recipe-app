# The Good Table

A responsive recipe website built with Laravel 12, Blade, CSS, and vanilla JavaScript. Visitors can search and filter recipes, save favorites in their session, and view full recipe instructions. Recipe administrators can maintain the database-backed recipe collection from a protected admin area.

## Requirements

- PHP 8.2 or later with Laravel-supported PDO database extensions
- Composer
- MySQL or SQLite configured using your Laravel `.env` database settings

## Install and start

```powershell
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed --class=RecipeSeeder
php artisan serve
```

Visit `http://127.0.0.1:8000` to browse recipes, `http://127.0.0.1:8000/about` for the About Us page, and `http://127.0.0.1:8000/admin/login` for recipe administration.

The migrations create the recipe and newsletter tables, add a default-disabled administrator flag to user accounts, and remove the old customer portal tables. Existing recipe administrator accounts are carried over to the users table. Seed the sample recipes with `php artisan db:seed --class=RecipeSeeder`; the seeder is safe to run again and updates existing examples rather than duplicating them.

## Create an administrator

Run the interactive command below after migrating. It prompts for an email address and a password without displaying the password while you type. New administrator passwords must contain at least eight characters, including uppercase and lowercase letters, a number, and a symbol.

```powershell
php artisan recipe-admin:create
```

You can also supply an email address as the command argument:

```powershell
php artisan recipe-admin:create admin@example.com
```

If the address already belongs to a user, the command sets a new password for that account and grants it recipe administrator access. Administrators sign in at `/admin/login`; only accounts explicitly granted the administrator flag can access the recipe-management pages.

## Frontend

The main site is rendered with Blade. Responsive styles and small progressive-enhancement scripts live under `public/css` and `public/js` and are served directly, so the website does not require a JavaScript package install or build step. Recipe photos are stored in `public/images`; new photos uploaded in the admin panel are saved under `public/images/recipes` and referenced directly from each database record.

## Tests

```powershell
php artisan test --filter=RecipePagesTest
```
