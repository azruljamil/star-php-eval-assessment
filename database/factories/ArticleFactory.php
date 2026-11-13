<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'summary' => fake()->sentence(14),
            'body' => implode("\n\n", fake()->paragraphs(5)),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'permalink' => Str::slug($title).'-'.Str::uuid(),
            'category_id' => Category::factory(),
            'status' => 'published',
            'thumbnail_url' => null,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'draft', 'published_at' => null]);
    }
}
