<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'tenant'; // must match the middleware
    protected $fillable = ['title', 'content', 'user_id'];
}
