<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'scheduled_at',
        'status',
        'interviewer_name',
        'notes',
        'result',
        'feedback'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
