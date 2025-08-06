<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Hash;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:student')->except('logout');
    }


    public function getRegister(){
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.profile.form');
        }
        return view('landing-page.student_register');
    }

    public function postRegister(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('student')->login($student);

        return redirect()->route('student.profile.form');
    }

    public function getLogin(){
        if (Auth::guard('student')->check()) {
            return redirect()->route('student.profile.form');
        }
        return view('landing-page.student_login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('student')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('landing_page');
    }



}
