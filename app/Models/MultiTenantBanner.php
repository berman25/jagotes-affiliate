<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiTenantBanner extends Model
{
    use HasFactory;

    protected $primaryKey = 'site_id';

    public $incrementing = false;

    protected $fillable = [
        'site_id',
        'login_banner_1',
        'login_banner_2',
        'login_banner_3',
        'free_tryout',
        'free_webinar',
        'simulasi_id',
        'module_id'
    ];

    public $timestamps = false;

}
