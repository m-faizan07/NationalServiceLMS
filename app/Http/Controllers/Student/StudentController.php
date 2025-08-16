<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ApplicationStatus;
use App\Models\Student;
use App\Models\StudentDocument;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(){
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }
        return view('landing-page.index');
    }

    // public function jobPortal(){
    //     $students =  Student::with(['profile','addresses'])->get();
    // //    $student =  StudentDocument::get();
    // //    $student =  StudentProfile::get();
    // //    $student =  ApplicationStatus::get();
    //      dd($students);
    //     // if (Auth::guard('student')->check()) {
    //     //     return redirect()->route('student.job_portal');
    //     // }
    //     return view('landing-page.student.job_portal');
    // }

    public function jobPortal() {
        $students = Student::with(['profile', 'addresses'])->get();

        return view('landing-page.student.job_portal', compact('students'));
    }

    public function contact(){
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }
        return view('landing-page.student_contact');
    }
}
