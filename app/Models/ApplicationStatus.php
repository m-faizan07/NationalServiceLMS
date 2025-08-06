<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'status', 'feedback', 'interview_date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
