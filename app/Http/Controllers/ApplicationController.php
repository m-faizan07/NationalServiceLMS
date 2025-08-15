<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Auth;

class ApplicationController extends Controller
{
    public function index(){
        if(Auth::user()->type == 'super admin')
        {
            $students = Student::has('profile')->with(['profile','addresses','parentDetail','documents'])->get();

            return view('applications.index', compact('students'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function acceptRequest($id, $response){
        if(Auth::user()->type == 'super admin')
        {
            $student = Student::where('id', $id)->first();
            $student->status = $response;
            $student->update();
            return redirect()->back()->with('success', __('Application ' . ucfirst($response)));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
