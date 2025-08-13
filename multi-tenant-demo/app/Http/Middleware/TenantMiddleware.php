<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost(); // e.g., tenant1.localhost

        $tenant = Tenant::where('domain', $host)->first();

        if (!$tenant) {
            abort(404, 'Tenant not found');
        }

        // Set the full tenant connection
        config([
            'database.connections.tenant' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => $tenant->database,
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
        ]);

        // Purge and reconnect tenant DB
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Make sure this connection is actually used immediately
        DB::setDefaultConnection('tenant');

        return $next($request);
    }
}
