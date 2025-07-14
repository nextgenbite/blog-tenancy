<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::insert([
            ['name' => 'Basic', 'price' => 0, 'max_posts' => 10, 'custom_domain' => false],
            ['name' => 'Pro', 'price' => 19.99, 'max_posts' => 100, 'custom_domain' => true],
            ['name' => 'Enterprise', 'price' => 49.99, 'max_posts' => null, 'custom_domain' => true],
        ]);
    }
}
