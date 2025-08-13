<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use App\Models\Post;
use App\Models\User;

class TenantPostsSeeder extends Seeder
{
    public function run()
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Switch DB to tenant
            config(['database.connections.tenant.database' => $tenant->database]);
            DB::purge('tenant');
            DB::reconnect('tenant');

            // Create a user inside the tenant DB
            $tenantUser = User::firstOrCreate(
                ['email' => 'tenantuser@example.com'],
                [
                    'name' => "Tenant User for {$tenant->name}",
                    'password' => bcrypt('password')
                ]
            );

            // Create a post using the tenant user
            Post::create([
                'title' => "Post for {$tenant->name}",
                'content' => "This is a sample post for {$tenant->name} database.",
                'user_id' => $tenantUser->id, // now valid
            ]);
        }
    }
}
