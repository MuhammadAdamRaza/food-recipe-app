<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class CreateRecipeAdmin extends Command
{
    protected $signature = 'recipe-admin:create {email? : Email address of the recipe administrator}';

    protected $description = 'Create or promote a user account as a recipe administrator';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Administrator email');

        try {
            $email = Validator::make(
                ['email' => $email],
                ['email' => ['required', 'email', 'max:100']],
            )->validate()['email'];
        } catch (ValidationException $exception) {
            $this->error($exception->errors()['email'][0]);

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();
        $password = $this->secret($user ? 'Set a new administrator password' : 'Administrator password');

        try {
            Validator::make(
                ['password' => $password],
                ['password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()]],
            )->validate();
        } catch (ValidationException $exception) {
            $this->error($exception->errors()['password'][0]);

            return self::FAILURE;
        }

        if (! $user) {
            $name = $this->ask('Administrator name', 'Recipe Administrator');
            $user = new User([
                'name' => $name,
                'email' => $email,
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($password),
            'is_admin' => true,
        ])->save();

        $this->components->info("Recipe administrator {$email} is ready. Sign in at /admin/login.");

        return self::SUCCESS;
    }
}
