<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuiz extends Model
{
    protected $table = 'course_quiz';

    protected $fillable = [
        'id',
        'name'
    ];

    public $incrementing = false;
}
