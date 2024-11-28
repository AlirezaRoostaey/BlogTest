<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        return [

            'title' => $this->faker->word,
            'slug' => $this->faker->word,
            'content' => $this->faker->sentence,
            'publish_at' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'status' => 'approved',
        ];
    }
}
