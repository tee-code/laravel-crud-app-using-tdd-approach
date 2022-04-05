<?php

namespace Database\Factories;

use App\Http\Traits\PostTrait;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    use PostTrait, RefreshDatabase;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence(),
            "body" => $this->faker->text(),
            "slug" => $this->createSlug($this->faker->unique()->sentence(2)),
            "category_id" => Category::factory()->create()->id,
            "user_id" => User::factory()->create()->id
        ];
    }
}
