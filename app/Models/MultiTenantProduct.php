<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiTenantProduct extends Model
{
    use HasFactory;

    protected $casts = [
        'benefits' => 'array',
    ];
}
