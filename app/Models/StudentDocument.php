<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'type', 'file_path', 'report_number', 
        'school_name', 'year', 'subjects', 'result'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
