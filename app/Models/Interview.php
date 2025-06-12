<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = [
        'role',
        'type',
        'level',
        'techstack',
        'questions',
        'user_id',
        'finalized',
        'cover_image',
    ];

    protected $casts = [
        'techstack' => 'array',
        'questions' => 'array',
        'finalized' => 'boolean',
    ];
}
