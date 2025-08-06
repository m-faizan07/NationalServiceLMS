<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\Auth;

class ApplicationStatusController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $status = $student->applicationStatus;
        
        return view('landing-page.student.application-status', compact('status'));
    }
}