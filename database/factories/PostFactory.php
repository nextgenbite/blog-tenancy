<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\TenantUser;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();

        return [
            'tenant_id'   => (string) Str::uuid(), // override when seeding
            'user_id'     => TenantUser::factory(), // override in seeder
            'category_id' => Category::factory(),   // override in seeder
            'title'       => $title,
            'slug'        => Str::slug($title) . '-' . Str::random(6),
            'content'     => $this->faker->paragraphs(5, true),
            'is_published' => $this->faker->boolean(80),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['is_published' => true]);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}
