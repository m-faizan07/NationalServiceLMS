<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        
        // Redirect if profile not completed
        if (!$student->profile_completed || !$student->profile) {
            return redirect()->route('student.profile.form')
                ->with('error', 'Please complete your profile first');
        }

        $documents = $student->documents ?? collect();
        
        $needsParentConsent = optional($student->profile)->needsParentConsent() ?? false;
        
        return view('landing-page.student.documents', [
            'documents' => $documents,
            'needsParentConsent' => $needsParentConsent
        ]);
    }

    public function store(Request $request)
    {
        $student = Auth::guard('student')->user();

        // Allowed document keys matching your input names
        $documents = [
            'national_id',
            'passport_photo',
            'school_leaving',
            'police_report',
            'parent_consent',
            'olevel',
            'alevel'
        ];

        foreach ($documents as $type) {
            if ($request->hasFile($type)) {
                $file = $request->file($type);

                // Optional: validate file size and type
                $request->validate([
                    $type => 'mimes:pdf,jpg,jpeg,png|max:2048' // 2MB max
                ]);

                // Store file
                $filePath = $file->store("documents/{$student->id}", 'public');

                // Save record in DB
                StudentDocument::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'type'       => $type
                    ],
                    [
                        'file_path'  => $filePath
                    ]
                );
            }
        }

        return back()->with('success', 'Documents uploaded successfully!');
    }
    
    public function download(StudentDocument $document)
    {
        // Verify document belongs to current student
        if ($document->student_id !== Auth::guard('student')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Verify file path exists and is valid
        if (empty($document->file_path)) {
            abort(404, 'Document path not found');
        }

        // Verify file exists in storage
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found in storage');
        }

        try {
            return Storage::disk('public')->download($document->file_path);
        } catch (\Exception $e) {
            abort(500, 'Error downloading file: '.$e->getMessage());
        }
    }
    
    public function destroy(StudentDocument $document)
    {
        // Verify document belongs to current student
        if ($document->student_id !== Auth::guard('student')->id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Only attempt deletion if file_path exists
            if (!empty($document->file_path)) {
                // Check if file exists before trying to delete
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                } else {
                    \Log::warning("File not found during deletion attempt", [
                        'document_id' => $document->id,
                        'file_path' => $document->file_path
                    ]);
                }
            }

            // Always delete the database record
            $document->delete();

            return back()->with('success', 'Document deleted successfully');

        } catch (\Exception $e) {
            \Log::error("Document deletion failed", [
                'error' => $e->getMessage(),
                'document_id' => $document->id
            ]);
            return back()->with('error', 'Failed to delete document');
        }
    }
}