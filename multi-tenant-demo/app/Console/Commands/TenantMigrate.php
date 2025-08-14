<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant; // Your central tenants model

class TenantMigrate extends Command
{
    // Command signature
    protected $signature = 'tenant:migrate
                            {db? : The tenant database name (leave empty for all tenants)}
                            {--fresh : Run migrate:fresh instead of migrate}';

    protected $description = 'Run migrations for a specific tenant or all tenants';

    public function handle()
    {
        $dbName = $this->argument('db');
        $fresh = $this->option('fresh');

        $tenants = [];

        if ($dbName) {
            $tenants[] = ['database' => $dbName];
        } else {
            // Fetch all tenants from central DB
            $tenants = Tenant::all()->map(function ($tenant) {
                return ['database' => $tenant->database];
            })->toArray();
        }

        foreach ($tenants as $tenant) {
            $database = $tenant['database'];
            $this->info("Migrating tenant database: {$database}");

            // Set dynamic DB config
            Config::set('database.connections.tenant.database', $database);
            DB::purge('tenant');
            DB::reconnect('tenant');

            // Run migrations
            if ($fresh) {
                Artisan::call('migrate:fresh', [
                    '--database' => 'tenant',
                    '--path' => 'database/migrations/tenant',
                    '--force' => true,
                ]);
            } else {
                Artisan::call('migrate', [
                    '--database' => 'tenant',
                    '--path' => 'database/migrations/tenant',
                    '--force' => true,
                ]);
            }

            $this->info(Artisan::output());
        }

        $this->info('Tenant migrations completed.');
    }
}
