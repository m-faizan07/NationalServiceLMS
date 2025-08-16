<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f8;
}

.dashboard {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    background: #004080;
    color: white;
    display: flex;
    flex-direction: column;
    padding: 1rem;
}

.sidebar h2 {
    margin-bottom: 2rem;
    text-align: center;
}

.sidebar a {
    color: white;
    text-decoration: none;
    padding: 0.75rem 1rem;
    margin: 0.25rem 0;
    border-radius: 5px;
    display: flex;
    align-items: center;
}

.sidebar a:hover, .sidebar a.active {
    background: rgba(255, 255, 255, 0.1);
}

.sidebar a i {
    margin-right: 10px;
}

.main {
    flex-grow: 1;
    padding: 2rem;
    overflow-y: auto;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.topbar h1 {
    margin: 0;
    font-size: 1.5rem;
}

.icons a {
    color: #333;
    margin-left: 1rem;
}

.favClass {
    margin-right: 10px !important;
}

.form-section {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.form-section h2 {
    margin-top: 0;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

.form-group input[type="submit"],
.btn {
    background: #004080;
    color: white;
    border: none;
    cursor: pointer;
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    font-size: 1rem;
    transition: background 0.3s;
}

.form-group input[type="submit"]:hover,
.btn:hover {
    background: #003366;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.btn-primary {
    background: #004080;
}

.btn-danger {
    background: #dc3545;
}

.alert {
    padding: 1rem;
    border-radius: 5px;
    margin-bottom: 1rem;
}

.alert-success {
    background: #d4edda;
    color: #155724;
}

.alert-info {
    background: #d1ecf1;
    color: #0c5460;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
}

.document-table {
    width: 100%;
    border-collapse: collapse;
}

.document-table th,
.document-table td {
    padding: 0.75rem;
    border: 1px solid #ddd;
    text-align: left;
}

.document-table th {
    background: #f4f4f4;
}

.status-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.status-header {
    margin-bottom: 1rem;
}

.status-incomplete {
    color: #ffc107;
}

.status-submitted {
    color: #17a2b8;
}

.status-under_review {
    color: #007bff;
}

.status-selected_for_interview {
    color: #6610f2;
}

.status-accepted {
    color: #28a745;
}

.status-rejected {
    color: #dc3545;
}
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2>Student Panel</h2>
            <a href="{{ route('student.profile.form') }}" class="{{ request()->routeIs('student.profile.*') ? 'active' : '' }}">
                <i class="fa fa-file-alt"></i> Profile Form
            </a>
            <a href="{{ route('student.documents') }}" class="{{ request()->routeIs('student.documents*') ? 'active' : '' }}">
                <i class="fa fa-file-upload"></i> Documents
            </a>
            <a href="{{ route('student.status') }}" class="{{ request()->routeIs('student.status') ? 'active' : '' }}">
                <i class="fa fa-info-circle"></i> Application Status
            </a>
        </div>
        <div class="main">
            <div class="topbar">
                <h1>Welcome, {{ Auth::guard('student')->user()->name }}</h1>
                <div class="icons">
                    <a href=""><i class="fas fa-bell favClass" title="Notifications"></i></a>
                    <a href=""><i class="fas fa-cog favClass" title="Settings"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt favClass" title="Logout"></i>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    <script>
        // Document type selector functionality
document.addEventListener('DOMContentLoaded', function() {
    const typeSelector = document.querySelector('.document-type-selector');
    if (typeSelector) {
        typeSelector.addEventListener('change', function() {
            const type = this.value;
            const fieldsContainer = document.getElementById('document-fields');
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
    }
});
    </script>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .status-step {
            text-align: center;
        }
        .status-step .circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            margin-bottom: 5px;
        }
        .status-step.completed .circle {
            background-color: #28a745;
            color: white;
        }
        .status-step.current .circle {
            background-color: #0d6efd;
            color: white;
        }
        .doc-status {
            font-size: 0.9rem;
            font-weight: bold;
        }
        .doc-status.uploaded {
            color: #28a745;
        }
        .doc-status.pending {
            color: #ffc107;
        }
        .doc-status.not-required {
            color: #6c757d;
        }
        .nav-tabs .nav-link {
            color: #6c757d;
        }
        .btn-link i {
            color: black;
        }

        .btn-link:hover i {
            color: black;
        }
        .status-step {
            text-align: center;
            position: relative;
            flex: 1;
        }

        .status-step.completed {
            color: #28a745; /* Green for completed steps */
        }

        .status-step.current {
            color: #007bff; /* Blue for current step */
        }

        .status-step .circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 5px;
        }

        .status-step.completed .circle {
            border-color: #28a745;
            background: #28a745;
            color: white;
        }

        .status-step.current .circle {
            border-color: #007bff;
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Student Dashboard</h4>
        <div>
            <a href="{{ url('/job-portal') }}">Job Portal</a>
            <a href="javascript:void(0)"
            class="btn btn-link p-0 me-3"
            id="openNotifications">
                <i class="bi bi-bell fs-5"></i>
            </a>

            <a href="" class="btn btn-link p-0 me-3">
                <i class="bi bi-gear fs-5"></i>
            </a>
            <a href="{{ route('logout') }}" class="btn btn-link p-0">
                <i class="bi bi-box-arrow-right fs-5"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="dashboardTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="application-tab" data-bs-toggle="tab" data-bs-target="#application" type="button" role="tab">Application</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">Documents</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">Notifications</button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Application Tab -->
                <div class="tab-pane fade show active" id="application" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Application Status</h5>
                            <p class="text-muted">Track your application progress</p>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Status: <span class="badge bg-warning text-dark">
                                    @if(!empty($student))
                                        {{ucfirst($student->status)}}
                                    @else
                                        Pending
                                    @endif
                                </span></span>
                                @php
                                    $percentage = 0;
                                    $statusClass = 'bg-warning';
                                    
                                    // Progress calculation
                                    if(!empty($profile)) {
                                        $percentage = 50;
                                        $statusClass = 'bg-primary';
                                    }
                                    if($student->status === 'approved') {
                                        $percentage = 75;
                                        $statusClass = 'bg-info';
                                    }
                                    if($student->status === 'interview') {
                                        $percentage = 100;
                                        $statusClass = 'bg-success';
                                    }
                                    if($student->status === 'rejected') {
                                        $percentage = 100;
                                        $statusClass = 'bg-danger';
                                    }
                                @endphp
                                {{ $percentage }}%
                            </div>
                            <div class="progress mb-4">
                                <div class="progress-bar {{ $statusClass }}" 
                                    style="width: {{ $percentage }}%;"
                                    role="progressbar" 
                                    aria-valuenow="{{ $percentage }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <!-- Step 1: Submitted -->
                                <div class="status-step completed">
                                    <div class="circle">✓</div>
                                    <div>Submitted</div>
                                </div>
                                
                                <!-- Step 2: Profile Review -->
                                <div class="status-step @if($percentage >= 50) completed @endif">
                                    <div class="circle">@if($percentage >= 50) ✓ @else ⏳ @endif</div>
                                    <div>Profile Review</div>
                                </div>
                                
                                <!-- Step 3: Approval -->
                                <div class="status-step @if($percentage >= 75) completed @endif">
                                    <div class="circle">@if($percentage >= 75) ✓ @else • @endif</div>
                                    <div>Approval</div>
                                </div>
                                
                                <!-- Step 4: Interview/Completion -->
                                <div class="status-step @if($percentage == 100) completed @endif">
                                    <div class="circle">
                                        @if($percentage == 100)
                                            @if($student->status === 'rejected') ✗ @else ✓ @endif
                                        @else 
                                            •
                                        @endif
                                    </div>
                                    <div>
                                        @if($student->status === 'rejected')
                                            Rejected
                                        @else
                                            Interview
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="mb-4">Student Application Form</h2>
                            <form method="POST" action="{{ route('student.profile.submit') }}">
                                @csrf

                                <h4 class="mb-3">Personal Information</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $profile->first_name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $profile->last_name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nid" class="form-label">National ID</label>
                                        <input type="text" id="nid" name="nid" class="form-control" value="{{ old('nid', $profile->nid ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="mobile_no" class="form-label">Mobile No</label>
                                        <input type="text" id="mobile_no" name="mobile_no" class="form-control" value="{{ old('mobile_no', $profile->mobile_no ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob', $profile->dob ?? '') }}" required>
                                        <small class="text-muted">Age must be between 16 to 28 years</small>
                                    </div>
                                </div>

                                <h4 class="mt-4 mb-3">Permanent Address</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Atoll</label>
                                        <input type="text" name="permanent_atoll" class="form-control" value="{{ old('permanent_atoll', $permanentAddress->atoll ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Island</label>
                                        <input type="text" name="permanent_island" class="form-control" value="{{ old('permanent_island', $permanentAddress->island ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">District</label>
                                        <input type="text" name="permanent_district" class="form-control" value="{{ old('permanent_district', $permanentAddress->district ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="permanent_address" class="form-control" value="{{ old('permanent_address', $permanentAddress->address ?? '') }}" required>
                                    </div>
                                </div>

                                <h4 class="mt-4 mb-3">Present Address</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Atoll</label>
                                        <input type="text" name="present_atoll" class="form-control" value="{{ old('present_atoll', $presentAddress->atoll ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Island</label>
                                        <input type="text" name="present_island" class="form-control" value="{{ old('present_island', $presentAddress->island ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">District</label>
                                        <input type="text" name="present_district" class="form-control" value="{{ old('present_district', $presentAddress->district ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="present_address" class="form-control" value="{{ old('present_address', $presentAddress->address ?? '') }}" required>
                                    </div>
                                </div>

                                <h4 class="mt-4 mb-3">Parent Details</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name', $parentDetail->name ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Relation</label>
                                        <input type="text" name="parent_relation" class="form-control" value="{{ old('parent_relation', $parentDetail->relation ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Atoll</label>
                                        <input type="text" name="parent_atoll" class="form-control" value="{{ old('parent_atoll', $parentDetail->atoll ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Island</label>
                                        <input type="text" name="parent_island" class="form-control" value="{{ old('parent_island', $parentDetail->island ?? '') }}" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="parent_address" class="form-control" value="{{ old('parent_address', $parentDetail->address ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mobile No</label>
                                        <input type="text" name="parent_mobile_no" class="form-control" value="{{ old('parent_mobile_no', $parentDetail->mobile_no ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="parent_email" class="form-control" value="{{ old('parent_email', $parentDetail->email ?? '') }}">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

                <!-- Documents Tab -->
                <div class="tab-pane fade" id="documents" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Document Management</h5>
                            <p class="text-muted">Upload and manage your application documents</p>

                            <!-- Form -->
                            <form id="documentUploadForm"
                                action="{{ route('student.documents.store') }}"
                                method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="list-group">
                                    @php
                                        $docTypes = [
                                            'national_id'     => 'National ID Copy',
                                            'passport_photo'  => 'Passport Photo',
                                            'school_leaving'  => 'School Leaving Certificate',
                                            'police_report'   => 'Police Report',
                                            'parent_consent'  => 'Parent Consent',
                                            'olevel'          => 'O-Level Certificate',
                                            'alevel'          => 'A-Level Certificate',
                                        ];
                                    @endphp

                                    @foreach($docTypes as $type => $label)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $label }}</span>
                                            <div class="d-flex align-items-center gap-2">

                                                @if(isset($documents[$type]))
                                                    {{-- Download link --}}
                                                    <a href="{{ asset('storage/'.$documents[$type]->file_path) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </a>

                                                    {{-- Delete link --}}
                                                    <form action="{{ url('student.documents.destroy', $documents[$type]->id) }}"
                                                        method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>

                                                @else
                                                    {{-- File input only if no document --}}
                                                    <input type="file"
                                                        name="{{ $type }}"
                                                        class="form-control form-control-sm d-inline-block"
                                                        style="width:auto"
                                                        accept=".pdf,.jpg,.jpeg,.png">
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Profile Tab -->
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile Information</h5>
                            <p class="text-muted">View and update your personal information</p>

                            <div class="mb-3 row">
                                <label class="col-sm-3 fw-bold">Full Name</label>
                                <div class="col-sm-9">{{$profile->first_name ?? 'N/A'}} {{$profile->last_name ?? ''}}</div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 fw-bold">National ID</label>
                                <div class="col-sm-9">{{$profile->nid ?? 'N/A'}}</div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 fw-bold">Email</label>
                                <div class="col-sm-9">{{$parentDetail->email ?? 'N/A'}}</div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 fw-bold">Phone</label>
                                <div class="col-sm-9">{{$profile->mobile_no ?? 'N/A'}}</div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 fw-bold">Date of Birth</label>
                                <div class="col-sm-9">
                                    @if(!empty($profile->dob))
                                        {{ \Carbon\Carbon::parse($profile->dob ?? '')->format('d M, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 fw-bold">Age</label>
                                <div class="col-sm-9">
                                    @if(!empty($profile->dob))
                                        {{ \Carbon\Carbon::parse($profile->dob)->age }} years
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Notifications Tab -->
                <div class="tab-pane fade" id="notifications" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5>Notifications</h5>
                            <p class="text-muted">No notifications yet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5>Quick Actions</h5>
                    <button type="submit" form="documentUploadForm" class="btn btn-primary w-100 mb-2">
                        Upload Documents
                    </button>
                    <button class="btn btn-outline-secondary w-100 mb-2">Download Application</button>
                    <button class="btn btn-outline-secondary w-100">Update Profile</button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>Contact Support</h5>
                    <p><strong>Email:</strong><br> support@nationalservice.gov.mv</p>
                    <p><strong>Phone:</strong><br> +960 320-5500</p>
                    <p><strong>Office Hours:</strong><br> 8:00 AM - 4:00 PM</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script>
function updateDocStatus(input) {
    const file = input.files[0];
    const statusEl = input.parentElement.querySelector('.doc-status');

    if (!file) {
        statusEl.textContent = 'Pending';
        statusEl.classList.remove('text-success');
        statusEl.classList.add('text-danger');
        return;
    }

    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('File size must be under 2MB.');
        input.value = '';
        statusEl.textContent = 'Pending';
        statusEl.classList.remove('text-success');
        statusEl.classList.add('text-danger');
        return;
    }

    // Validate file type
    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        alert('Only PDF, JPG, JPEG, PNG files are allowed.');
        input.value = '';
        statusEl.textContent = 'Pending';
        statusEl.classList.remove('text-success');
        statusEl.classList.add('text-danger');
        return;
    }

    // If valid
    statusEl.textContent = 'Uploaded';
    statusEl.classList.remove('text-danger');
    statusEl.classList.add('text-success');
}
</script> -->

<script>
    document.getElementById('openNotifications').addEventListener('click', function () {
    var triggerEl = document.querySelector('#notifications-tab');
    var tab = new bootstrap.Tab(triggerEl);
    tab.show();
});

(function() {
  const form = document.getElementById('profileForm');

  // utility to show feedback
  function setInvalid(input, message) {
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    let feedback = input.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
      feedback = document.createElement('div');
      feedback.className = 'invalid-feedback';
      input.parentNode.insertBefore(feedback, input.nextSibling);
    }
    feedback.textContent = message;
  }

  function setValid(input) {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    const feedback = input.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
      feedback.textContent = '';
    }
  }

  function clearValidation(input) {
    input.classList.remove('is-invalid', 'is-valid');
    const feedback = input.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) feedback.textContent = '';
  }

  // field validators
  function validateFirstName() {
    const input = document.getElementById('first_name');
    const val = (input.value || '').trim();
    if (!val) {
      setInvalid(input, 'First name is required.');
      return false;
    }
    setValid(input);
    return true;
  }

  function validateDOB() {
    const input = document.getElementById('dob');
    const val = (input.value || '').trim();
    if (!val) {
      setInvalid(input, 'Date of birth is required.');
      return false;
    }
    // optional: check age range 16-28 (comment/uncomment if needed)
    const dob = new Date(val);
    const diff = Date.now() - dob.getTime();
    const age = Math.floor(diff / (1000*60*60*24*365.25));
    if (age < 16 || age > 28) { setInvalid(input, 'Age must be between 16 and 28 years.'); return false; }

    setValid(input);
    return true;
  }

  function validateNID() {
    const input = document.getElementById('nid');
    const val = (input.value || '').trim();
    if (!val) {
      setInvalid(input, 'National ID is required.');
      return false;
    }
    if (!/^\d+$/.test(val)) {
      setInvalid(input, 'National ID must contain only digits.');
      return false;
    }
    setValid(input);
    return true;
  }

  function validateMobile() {
    const input = document.getElementById('mobile_no');
    const val = (input.value || '').trim();
    if (!val) {
      setInvalid(input, 'Mobile number is required.');
      return false;
    }
    if (!/^\d+$/.test(val)) {
      setInvalid(input, 'Mobile number must contain only digits.');
      return false;
    }
    if (val.length > 15) {
      setInvalid(input, 'Mobile number must be at most 15 digits.');
      return false;
    }
    setValid(input);
    return true;
  }

  // sanitize inputs while typing: keep only digits for nid and mobile
  ['nid', 'mobile_no'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    el.addEventListener('input', function() {
      const start = el.selectionStart;
      // remove all non-digit chars
      const clean = el.value.replace(/\D+/g, '');
      el.value = clean;
      // remove validation state when typing
      clearValidation(el);
      // try re-validate lightly
      if (id === 'nid' && clean !== '') validateNID();
      if (id === 'mobile_no' && clean !== '') validateMobile();
      // restore cursor near end (simple approach)
      el.setSelectionRange(el.value.length, el.value.length);
    });
  });

  // validate on blur for immediate feedback
  document.getElementById('first_name').addEventListener('blur', validateFirstName);
  document.getElementById('dob').addEventListener('blur', validateDOB);
  document.getElementById('nid').addEventListener('blur', validateNID);
  document.getElementById('mobile_no').addEventListener('blur', validateMobile);

  // final form submit check
  form.addEventListener('submit', function(e) {
    let ok = true;

    if (!validateFirstName()) ok = false;
    if (!validateDOB()) ok = false;
    if (!validateNID()) ok = false;
    if (!validateMobile()) ok = false;

    if (!ok) {
        e.preventDefault();  // stops submission
        e.stopPropagation(); // stops bubbling
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.focus();
    }
});

})();

</script>
</body>
</html>
