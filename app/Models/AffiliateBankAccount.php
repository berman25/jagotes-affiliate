<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateBankAccount extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_number';

    public $incrementing = false;

    protected $fillable = [
        'account_number',
        'account_name',
        'bank_name',
        'affiliate_id'
    ];
}
