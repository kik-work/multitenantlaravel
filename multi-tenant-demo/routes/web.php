<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

// Ensure tenant connection is used
Route::get('/posts', function () {
    $posts = Post::all(); // uses tenant connection automatically
    return $posts;
});
