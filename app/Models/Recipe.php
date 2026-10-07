<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'cuisine',
        'description',
        'image_url',
        'prep_time',
        'cook_time',
        'servings',
        'difficulty',
        'rating',
        'ingredients',
        'instructions',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'ingredients' => 'array',
            'instructions' => 'array',
            'is_featured' => 'boolean',
            'rating' => 'decimal:1',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getTotalTimeAttribute(): int
    {
        return $this->prep_time + $this->cook_time;
    }

    public function getImageSrcAttribute(): string
    {
        $image = $this->attributes['image_url'] ?? null;

        if (! is_string($image) || $image === '') {
            return asset('images/fresh-ingredients.jpg');
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        return asset(ltrim($image, '/'));
    }
}
