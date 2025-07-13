<?php

namespace Database\Seeders;

use App\Models\{Tenant,TenantUser,Category,Post};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Stancl\Tenancy\Facades\Tenancy;

class TenancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centralDomain = parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST);
        $tenant1 = Tenant::create([
            'id' => 'tenant1',
            'company_name' => 'Tenant One Inc.',
            'domain' => "tenant1.{$centralDomain}",
            'name' => 'Tenant One Admin',
            'email' => "admin@tenant1.{$centralDomain}",
            'password' => bcrypt('password'),
        ]);
        $tenant1->createDomain(['domain' => "tenant1.{$centralDomain}"]);

        $tenant2 = Tenant::create([
            'id' => 'tenant2',
            'company_name' => 'Tenant Two LLC',
            'domain' => "tenant2.{$centralDomain}",
            'name' => 'Tenant Two Admin',
            'email' => "admin@tenant2.{$centralDomain}",
            'password' => bcrypt('password'),
        ]);
        $tenant2->createDomain(['domain' => "tenant2.{$centralDomain}"]);




        // 3. Seed tenant data
        Tenancy::initialize($tenant1);

        $admin = TenantUser::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Admin User',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $cat = Category::create([
            'tenant_id' => $tenant1->id,
            'name' => 'News'
        ]);

        Post::factory(5)->create([
            'tenant_id' => $tenant1->id,
            'user_id' => $admin->id,
            'category_id' => $cat->id,
        ]);

        Tenancy::end();
    }
}
