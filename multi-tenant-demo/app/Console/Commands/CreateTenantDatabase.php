<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateTenantDatabase extends Command
{
    protected $signature = 'tenant:create-db {name}';
    protected $description = 'Create a database for a tenant';

    public function handle()
    {
        $dbName = $this->argument('name');
        DB::statement("CREATE DATABASE `$dbName`");
        $this->info("Database '$dbName' created successfully.");
    }
}
