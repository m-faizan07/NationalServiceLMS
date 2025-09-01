<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTrainingEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'training_batch_id',
        'status',
        'enrollment_date',
        'completion_date',
        'notes'
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'completion_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function trainingBatch()
    {
        return $this->belongsTo(TrainingBatch::class);
    }
}
