@extends('landing-page.student.dashboard')

@section('content')
<div class="form-section">
    <h2>Document Upload</h2>
    
    @if(!Auth::guard('student')->user()->profile_completed)
        <div class="alert alert-warning">
            Please complete your profile before uploading documents.
        </div>
    @else
        <div class="document-upload">
            <h3>Upload Documents</h3>
            
            @if($needsParentConsent)
                <div class="alert alert-info">
                    Since you're under 18, you need to upload a parent consent form.
                </div>
                
                @if(!$documents->where('type', 'parent_consent')->first())
                    <div class="alert alert-warning">
                        <a href="#" class="download-consent-form">Download Parent Consent Form</a>
                        <p>Please have your parent/guardian sign this form and upload it</p>
                    </div>
                @endif
            @endif
            
            <form method="POST" action="{{ route('student.documents.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="type">Document Type</label>
                    <select id="type" name="type" class="document-type-selector" required>
                        <option value="">Select Document Type</option>
                        @if($needsParentConsent)
                            <option value="parent_consent">Parent Consent Form</option>
                        @endif
                        <option value="photo">Photo</option>
                        <option value="nid_copy">NID Copy</option>
                        <option value="school_leaving">School Leaving Certificate</option>
                        <option value="olevel">O-Level Certificate</option>
                        <option value="alevel">A-Level Certificate</option>
                        <option value="police_report">Police Report</option>
                    </select>
                </div>
                
                <!-- Dynamic fields based on document type -->
                <div id="document-fields">
                    <!-- Fields will be loaded here via JavaScript -->
                </div>
                
                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" id="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
                    <small>Allowed formats: PDF, JPG, JPEG, PNG (Max 2MB)</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Upload Document</button>
            </form>
        </div>
        
        <div class="document-list">
            <h3>Uploaded Documents</h3>
            
            @if(empty($documents) || $documents->isEmpty())
                <p>No documents uploaded yet.</p>
            @else
                <table class="document-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $document->type)) }}</td>
                                <td>
                                    <b>Details</b><br>
                                    @if($document->school_name)
                                        School: {{ $document->school_name }}<br>
                                    @endif
                                    @if($document->year)
                                        Year: {{ $document->year }}<br>
                                    @endif
                                    @if($document->report_number)
                                        Report No: {{ $document->report_number }}<br>
                                    @endif
                                    @if($document->subjects)
                                        Subjects: {{ $document->subjects }}<br>
                                    @endif
                                    @if($document->result)
                                        Result: {{ $document->result }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('student.documents.download', $document) }}" class="btn btn-sm btn-primary">Download</a>
                                    <form action="{{ route('student.documents.destroy', $document) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif
</div>


@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelector = document.querySelector('.document-type-selector');
    const fieldsContainer = document.getElementById('document-fields');
    
    typeSelector.addEventListener('change', function() {
        const type = this.value;
        let html = '';
        
        switch(type) {
            case 'school_leaving':
                html = `
                    <div class="form-group">
                        <label for="school_name">School Name</label>
                        <input type="text" id="school_name" name="school_name" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Year</label>
                        <input type="text" id="year" name="year" required>
                    </div>
                    <div class="form-group">
                        <label for="report_number">Report Number</label>
                        <input type="text" id="report_number" name="report_number" required>
                    </div>
                `;
                break;
                
            case 'olevel':
            case 'alevel':
                html = `
                    <div class="form-group">
                        <label for="school_name">School Name</label>
                        <input type="text" id="school_name" name="school_name" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Year</label>
                        <input type="text" id="year" name="year" required>
                    </div>
                    <div class="form-group">
                        <label for="subjects">Subjects</label>
                        <input type="text" id="subjects" name="subjects" required>
                    </div>
                    <div class="form-group">
                        <label for="result">Result</label>
                        <input type="text" id="result" name="result" required>
                    </div>
                `;
                break;
                
            case 'police_report':
                html = `
                    <div class="form-group">
                        <label for="report_number">Report Number</label>
                        <input type="text" id="report_number" name="report_number" required>
                    </div>
                `;
                break;
                
            default:
                html = '';
        }
        
        fieldsContainer.innerHTML = html;
    });
});
</script>