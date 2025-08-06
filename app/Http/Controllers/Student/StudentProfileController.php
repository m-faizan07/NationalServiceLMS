<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\Address;
use App\Models\ParentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function showForm()
    {
        $student = Auth::guard('student')->user();
        $profile = $student->profile;
        $permanentAddress = $student->addresses()->where('type', 'permanent')->first();
        $presentAddress = $student->addresses()->where('type', 'present')->first();
        $parentDetail = $student->parentDetail;

        return view('landing-page.student.profile-form', compact('profile', 'permanentAddress', 'presentAddress', 'parentDetail'));
    }

    public function submitForm(Request $request)
    {
        $student = Auth::guard('student')->user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nid' => 'required|string|max:255|unique:student_profiles,nid,'.$student->id.',student_id',
            'mobile_no' => 'required|string|max:20',
            'dob' => 'required|date',
            
            // Permanent address
            'permanent_atoll' => 'required|string|max:255',
            'permanent_island' => 'required|string|max:255',
            'permanent_district' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:500',
            
            // Present address
            'present_atoll' => 'required|string|max:255',
            'present_island' => 'required|string|max:255',
            'present_district' => 'required|string|max:255',
            'present_address' => 'required|string|max:500',
            
            // Parent details
            'parent_name' => 'required|string|max:255',
            'parent_relation' => 'required|string|max:255',
            'parent_atoll' => 'required|string|max:255',
            'parent_island' => 'required|string|max:255',
            'parent_address' => 'required|string|max:500',
            'parent_mobile_no' => 'required|string|max:20',
            'parent_email' => 'nullable|email|max:255',
        ]);

        // Save student profile
        $profile = StudentProfile::updateOrCreate(
            ['student_id' => $student->id],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'nid' => $validated['nid'],
                'mobile_no' => $validated['mobile_no'],
                'dob' => $validated['dob'],
            ]
        );

        // Save permanent address
        Address::updateOrCreate(
            ['student_id' => $student->id, 'type' => 'permanent'],
            [
                'atoll' => $validated['permanent_atoll'],
                'island' => $validated['permanent_island'],
                'district' => $validated['permanent_district'],
                'address' => $validated['permanent_address'],
            ]
        );

        // Save present address
        Address::updateOrCreate(
            ['student_id' => $student->id, 'type' => 'present'],
            [
                'atoll' => $validated['present_atoll'],
                'island' => $validated['present_island'],
                'district' => $validated['present_district'],
                'address' => $validated['present_address'],
            ]
        );

        // Save parent details
        ParentDetail::updateOrCreate(
            ['student_id' => $student->id],
            [
                'name' => $validated['parent_name'],
                'relation' => $validated['parent_relation'],
                'atoll' => $validated['parent_atoll'],
                'island' => $validated['parent_island'],
                'address' => $validated['parent_address'],
                'mobile_no' => $validated['parent_mobile_no'],
                'email' => $validated['parent_email'],
            ]
        );

        // Mark profile as completed
        $student->profile_completed = true;
        $student->save();

        return redirect()->route('student.profile.form')->with('success', 'Profile updated successfully!');
    }
}