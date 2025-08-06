<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function parentDetail()
    {
        return $this->hasOne(ParentDetail::class);
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }
}
