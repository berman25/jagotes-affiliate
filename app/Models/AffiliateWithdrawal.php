<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateWithdrawal extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'amount',
        'bank_account',
        'affiliate_id',
        'status'
    ];

    public $incrementing = false;

    protected $casts = [
        'bank_account' => 'array',
    ];
}
