<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $images = [
            ['main.jpg', 'main.jpg'],
            ['preview.jpg', 'full.jpeg'],
            ['preview_2.jpg', 'full_2.jpeg'],
            ['new_year.jpg', 'new_year.jpg'],
            ['president.jpg', 'president.jpg'],
        ];

        [$preview, $full] = fake()->randomElement($images);

        return [
            'date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'name' => fake('ru_RU')->sentence(6),
            'preview_image' => $preview,
            'full_image' => $full,
            'short_desc' => fake('ru_RU')->sentence(12),
            'desc' => fake('ru_RU')->paragraphs(3, true),
        ];
    }
}
