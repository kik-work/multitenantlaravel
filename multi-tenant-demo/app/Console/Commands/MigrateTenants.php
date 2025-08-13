<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\Tenant;

class MigrateTenants extends Command
{
    protected $signature = 'tenants:migrate';
    protected $description = 'Run migrations for all tenant databases';

    public function handle()
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $this->info("Migrating tenant: {$tenant->name}");

            // Set tenant database dynamically
            config(['database.connections.tenant.database' => $tenant->database]);
            DB::purge('tenant');
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--force' => true,
            ]);

            $this->info("Migration finished for: {$tenant->name}");
        }

        $this->info('All tenant migrations completed!');
    }
}
