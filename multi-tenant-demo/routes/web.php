<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route; // ✅ This is what was missing
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

// Ensure tenant connection is used
Route::get('/posts', function () {
    // Example: automatically determine tenant from subdomain or host
    $host = request()->getHost();

    if ($host === 'tenant1.localhost') {
        Config::set('database.connections.tenant.database', 'tenant1_db');
    } elseif ($host === 'tenant2.localhost') {
        Config::set('database.connections.tenant.database', 'tenant2_db');
    }

    DB::purge('tenant');       // refresh connection
    DB::reconnect('tenant');

    $posts = Post::all();      // fetch posts for the current tenant
    return view('posts', compact('posts'));
});
