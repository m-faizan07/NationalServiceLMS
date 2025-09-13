<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'unit',
        'unit_name',
        'position',
        'deployment_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'deployment_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
