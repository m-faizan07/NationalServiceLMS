<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'certificate_program_id',
        'completion_date',
        'certificate_number',
        'status',
        'notes'
    ];

    protected $casts = [
        'completion_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function certificateProgram()
    {
        return $this->belongsTo(CertificateProgram::class);
    }
}
