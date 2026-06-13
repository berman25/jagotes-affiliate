<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinktreeLink extends Model
{
    protected $fillable = [
        'linktree_category_id',
        'title',
        'subtitle',
        'url',
        'thumbnail_url',
        'icon_emoji',
        'open_in_new_tab',
        'is_active',
        'sort_order',
        'click_count',
    ];

    protected $casts = [
        'open_in_new_tab' => 'boolean',
        'is_active'       => 'boolean',
        'sort_order'      => 'integer',
        'click_count'     => 'integer',
    ];

    // ── Relations ────────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(LinktreeCategory::class, 'linktree_category_id');
    }

    // ── Helper ───────────────────────────────────────────────
    public function incrementClick(): void
    {
        $this->increment('click_count');
    }
}
