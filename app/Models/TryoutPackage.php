<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TryoutPackage extends Model
{
    use HasFactory;

    protected $casts = [
        'sidebar_info' => 'array',
        'items' => 'array',
    ];
}
