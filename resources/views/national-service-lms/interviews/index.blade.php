@extends('layouts.admin')

@section('page-title')
    Interviews Management
@endsection

@push('css-page')
    <style>
        .interview-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-scheduled { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-rescheduled { background: #fff3cd; color: #856404; }
        .result-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
        }
        .result-pass { background: #d4edda; color: #155724; }
        .result-fail { background: #f8d7da; color: #721c24; }
        .result-pending { background: #fff3cd; color: #856404; }
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            margin: 2px;
            display: inline-block;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; color: white; }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('national-service-lms.dashboard') }}">National Service LMS</a></li>
                    <li class="breadcrumb-item active">Interviews</li>
                </ol>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Interviews</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleInterviewModal">
                    <i class="fas fa-plus me-2"></i>Schedule New Interview
                </button>
            </div>
        </div>
    </div>

    <!-- Interviews List -->
    <div class="row">
        @forelse($interviews as $interview)
        <div class="col-md-6 col-lg-4">
            <div class="interview-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="mb-0">{{ $interview->student->name ?? 'Unknown Student' }}</h5>
                    <span class="status-badge status-{{ $interview->status }}">
                        {{ ucfirst($interview->status) }}
                    </span>
                </div>

                <div class="mb-3">
                    <p class="mb-1"><strong>Interviewer:</strong> {{ $interview->interviewer_name }}</p>
                    <p class="mb-1"><strong>Scheduled:</strong>
                        @if($interview->scheduled_at)
                            {{ \Carbon\Carbon::parse($interview->scheduled_at)->format('d/m/Y H:i') }}
                        @else
                            N/A
                        @endif
                    </p>
                    <p class="mb-1"><strong>Result:</strong>
                        @if($interview->result)
                            <span class="result-badge result-{{ $interview->result }}">
                                {{ ucfirst($interview->result) }}
                            </span>
                        @else
                            <span class="result-badge result-pending">Pending</span>
                        @endif
                    </p>
                    @if($interview->feedback)
                        <p class="mb-1"><strong>Feedback:</strong> {{ Str::limit($interview->feedback, 100) }}</p>
                    @endif
                    @if($interview->notes)
                        <p class="mb-1"><strong>Notes:</strong> {{ Str::limit($interview->notes, 100) }}</p>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">Created: {{ $interview->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        @if($interview->status === 'scheduled')
                            <button type="button" class="action-btn btn-success" data-bs-toggle="modal" data-bs-target="#updateResultModal{{ $interview->id }}" style="padding:2px;">
                                <i class="fas fa-pen"></i>
                            </button>
                        @endif
                        <button type="button" class="action-btn btn-warning" data-bs-toggle="modal" data-bs-target="#editInterviewModal{{ $interview->id }}" style="padding:2px;">
                           <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Result Modal -->
        <div class="modal fade" id="updateResultModal{{ $interview->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Interview Result - {{ $interview->student->name ?? 'Unknown Student' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('national-service-lms.interviews.update-result', $interview) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="result" class="form-label">Interview Result</label>
                                <select name="result" id="result" class="form-select" required>
                                    <option value="pass">Pass</option>
                                    <option value="fail">Fail</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="feedback" class="form-label">Feedback</label>
                                <textarea name="feedback" id="feedback" class="form-control" rows="3" placeholder="Enter interview feedback">{{ $interview->feedback }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Update Result</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Interview Modal -->
        <div class="modal fade" id="editInterviewModal{{ $interview->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Interview - {{ $interview->student->name ?? 'Unknown Student' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('national-service-lms.interviews.update-result', $interview) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="scheduled_at" class="form-label">Interview Date & Time</label>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control"
                                       value="{{ $interview->scheduled_at ? \Carbon\Carbon::parse($interview->scheduled_at)->format('Y-m-d\TH:i') : '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="interviewer_name" class="form-label">Interviewer Name</label>
                                <input type="text" name="interviewer_name" id="interviewer_name" class="form-control" value="{{ $interview->interviewer_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Any additional notes">{{ $interview->notes }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Interview</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h5>No interviews found</h5>
                <p>No interviews have been scheduled yet.</p>
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#scheduleInterviewModal">Schedule First Interview</button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($interviews->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $interviews->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Schedule Interview Modal -->
<div class="modal fade" id="scheduleInterviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule New Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('national-service-lms.interviews.schedule') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Select Student</label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            <option value="">Choose a student...</option>
                            @foreach($eligibleStudents as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }}) - {{ ucfirst(str_replace('_', ' ', $student->application_stage)) }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Only students eligible for interviews are shown</small>
                    </div>
                    <div class="mb-3">
                        <label for="scheduled_at" class="form-label">Interview Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="interviewer_name" class="form-label">Interviewer Name</label>
                        <input type="text" name="interviewer_name" id="interviewer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Any additional notes for the interview"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Schedule Interview</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
    // Set minimum date for interview scheduling to today
    document.getElementById('scheduled_at').min = new Date().toISOString().slice(0, 16);

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Enhanced student selection
    document.getElementById('student_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            console.log('Selected student:', selectedOption.text);
        }
    });

    // Form validation before submission
    document.querySelector('#scheduleInterviewModal form').addEventListener('submit', function(e) {
        const studentId = document.getElementById('student_id').value;
        const scheduledAt = document.getElementById('scheduled_at').value;
        const interviewerName = document.getElementById('interviewer_name').value;

        if (!studentId || !scheduledAt || !interviewerName) {
            e.preventDefault();
            alert('Please fill in all required fields');
            return false;
        }

        // Check if scheduled time is in the future
        const scheduledTime = new Date(scheduledAt);
        const now = new Date();
        if (scheduledTime <= now) {
            e.preventDefault();
            alert('Interview must be scheduled for a future date and time');
            return false;
        }
    });
</script>
@endpush
