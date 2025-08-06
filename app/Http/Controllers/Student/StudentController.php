<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
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

    public function contact(){
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }
        return view('landing-page.student_contact');
    }
}
