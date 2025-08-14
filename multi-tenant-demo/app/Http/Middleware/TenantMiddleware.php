<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost(); // e.g., tenant1.local
        $tenant = Tenant::where('domain', $host)->firstOrFail();

        // Set tenant database dynamically
        Config::set('database.connections.tenant.database', $tenant->database);
        Config::set('database.connections.tenant.username', $tenant->username);
        Config::set('database.connections.tenant.password', $tenant->password);

        // Refresh connection
        DB::purge('tenant');
        DB::reconnect('tenant');

        return $next($request);
    }
}
