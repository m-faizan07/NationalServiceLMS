<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'name', 'relation', 'atoll', 'island', 'address', 'mobile_no', 'email'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
