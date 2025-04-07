<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuiz extends Model
{
    protected $table = 'course_quiz';

    protected $fillable = [
        'id',
        'module_id',     
        'name',
        'duration',
        'is_active'
    ];

    public $incrementing = false;
}
