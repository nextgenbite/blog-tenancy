<?php

namespace Database\Factories;

use App\Models\TenantUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TenantUserFactory extends Factory
{
    protected $model = TenantUser::class;

    public function definition(): array
    {
        return [
            'tenant_id' => (string) Str::uuid(), // You should override this when seeding
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'role' => $this->faker->randomElement(['admin', 'reader']),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function reader(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'reader',
        ]);
    }
}
