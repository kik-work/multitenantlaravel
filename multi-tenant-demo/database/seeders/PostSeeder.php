<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::create([
            'title' => 'Hello Tenant',
            'body' => 'This is some example content for this tenant.',
        ]);

        Post::create([
            'title' => 'Another Post',
            'body' => 'More content here.',
        ]);
    }
}
