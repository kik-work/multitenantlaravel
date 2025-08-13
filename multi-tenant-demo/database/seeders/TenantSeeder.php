<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::create([
            'name' => 'Tenant 1',
            'domain' => 'tenant1.localhost',
            'database' => 'tenant1_db'
        ]);

        Tenant::create([
            'name' => 'Tenant 2',
            'domain' => 'tenant2.localhost',
            'database' => 'tenant2_db'
        ]);
    }
}
