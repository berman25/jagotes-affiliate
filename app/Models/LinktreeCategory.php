<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LinktreeCategory extends Model
{
    protected $fillable = [
        'linktree_profile_id',
        'name',
        'slug',
        'icon_emoji',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    // ── Relations ────────────────────────────────────────────
    public function profile(): BelongsTo
    {
        return $this->belongsTo(LinktreeProfile::class, 'linktree_profile_id');
    }

    public function links(): HasMany
    {
        return $this->hasMany(LinktreeLink::class)
                    ->orderBy('sort_order');
    }

    public function activeLinks(): HasMany
    {
        return $this->hasMany(LinktreeLink::class)
                    ->where('is_active', true)
                    ->orderBy('sort_order');
    }
}
