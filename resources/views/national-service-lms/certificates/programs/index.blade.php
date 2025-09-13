@extends('layouts.admin')

@section('page-title')
    Certificate Programs Management
@endsection

@push('css-page')
    <style>
        .program-card {
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
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
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
                    <li class="breadcrumb-item active">Certificate Programs</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Certificate Programs</h5>
                <a href="{{ route('national-service-lms.certificates.programs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create New Program
                </a>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <!-- Programs List -->
    <div class="row">
        @forelse($programs as $program)
        <div class="col-md-6 col-lg-4">
            <div class="program-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="mb-0">{{ $program->program_name }}</h5>
                    <span class="status-badge status-{{ $program->status }}">
                        {{ ucfirst($program->status) }}
                    </span>
                </div>

                <div class="mb-3">
                    <p class="mb-1"><strong>Duration:</strong> {{ $program->duration_months }} months</p>
                    <p class="mb-1"><strong>Cost:</strong> ${{ number_format($program->cost, 2) }}</p>
                    <p class="mb-1"><strong>Students Enrolled:</strong> {{ $program->student_certificates_count }}</p>
                    <p class="mb-1"><strong>Description:</strong> {{ Str::limit($program->description, 150) }}</p>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">Created: {{ $program->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        {{-- <a href="#" class="action-btn btn-primary">View Details</a>
                        <a href="#" class="action-btn btn-warning">Edit</a> --}}
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h5>No certificate programs found</h5>
                <p>No certificate programs have been created yet.</p>
                <a href="{{ route('national-service-lms.certificates.programs.create') }}" class="btn btn-primary mt-2">Create First Program</a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($programs->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $programs->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
