<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 90);
            $table->string('slug', 110)->unique();
            $table->string('category', 30)->index();
            $table->string('cuisine', 40);
            $table->string('description', 180);
            $table->string('image_url', 2048)->nullable();
            $table->unsignedSmallInteger('prep_time');
            $table->unsignedSmallInteger('cook_time')->default(0);
            $table->unsignedTinyInteger('servings');
            $table->string('difficulty', 20)->default('Easy');
            $table->decimal('rating', 2, 1)->default(4.8);
            $table->json('ingredients');
            $table->json('instructions');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('recipes');

    }
};
