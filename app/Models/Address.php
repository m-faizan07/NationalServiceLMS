<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'type', 'atoll', 'island', 'district', 'address'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
