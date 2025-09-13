<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'description',
        'duration_months',
        'cost',
        'status'
    ];

    public function studentCertificates()
    {
        return $this->hasMany(StudentCertificate::class);
    }
}
