<?php

namespace Database\Seeders;

use App\Models\{Tenant,TenantUser,Category,Post};
use Illuminate\Database\Seeder;
use Stancl\Tenancy\Facades\Tenancy;

class TenancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get central domain from APP_URL
        $centralDomain = parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST);

        // Create first tenant
        $tenant1 = Tenant::create([
            'id' => 'tenant1',
            'company_name' => 'Tenant One Inc.',
            'domain' => "tenant1.{$centralDomain}",
            'name' => 'Tenant One Admin',
            'email' => "admin@tenant1.{$centralDomain}",
            'password' => bcrypt('password'),
        ]);
        $tenant1->createDomain(['domain' => "tenant1.{$centralDomain}"]);

        // Create second tenant
        $tenant2 = Tenant::create([
            'id' => 'tenant2',
            'company_name' => 'Tenant Two LLC',
            'domain' => "tenant2.{$centralDomain}",
            'name' => 'Tenant Two Admin',
            'email' => "admin@tenant2.{$centralDomain}",
            'password' => bcrypt('password'),
        ]);
        $tenant2->createDomain(['domain' => "tenant2.{$centralDomain}"]);

        // Seed tenant1 data
        Tenancy::initialize($tenant1);

        // Create admin user for tenant1
        $admin = TenantUser::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Admin User',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create categories for tenant1
        $catNews = Category::create([
            'tenant_id' => $tenant1->id,
            'name' => 'News'
        ]);
        $catTech = Category::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Tech'
        ]);
        $catLife = Category::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Lifestyle'
        ]);

        // Create posts for each category
        Post::factory(5)->create([
            'tenant_id' => $tenant1->id,
            'user_id' => $admin->id,
            'category_id' => $catNews->id,
        ]);
        Post::factory(3)->create([
            'tenant_id' => $tenant1->id,
            'user_id' => $admin->id,
            'category_id' => $catTech->id,
        ]);
        Post::factory(2)->create([
            'tenant_id' => $tenant1->id,
            'user_id' => $admin->id,
            'category_id' => $catLife->id,
        ]);

        // Tag posts with more data
        // Create tags for tenant1
        $firstPost = Post::where('tenant_id', $tenant1->id)->first();
        $postId = $firstPost ? $firstPost->id : 1; // fallback to 1 if no post found

        $tagFeatured = \App\Models\Tag::create([
            'tenant_id' => $tenant1->id,
            'name' => 'featured',
            'author_name' => $admin->name,
            'post_id' => $postId,
        ]);
        $tagPopular = \App\Models\Tag::create([
            'tenant_id' => $tenant1->id,
            'name' => 'popular',
            'author_name' => $admin->name,
            'post_id' => $postId,
        ]);
        $tagEditorial = \App\Models\Tag::create([
            'tenant_id' => $tenant1->id,
            'name' => 'editorial',
            'author_name' => $admin->name,
            'post_id' => $postId,
        ]);
        // foreach (Post::where('tenant_id', $tenant1->id)->get() as $post) {
        //     $post->tags()->attach([
        //         $tagFeatured->id,
        //         $tagPopular->id,
        //         $tagEditorial->id
        //     ]);
        // }

        Tenancy::end();
    }
}
