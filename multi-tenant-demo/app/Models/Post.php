<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'tenant'; // dynamically set by middleware
}
