<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiTenantSite extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $casts = [
        'color' => 'array',
    ];

    public $incrementing = false;
}
