@extends('layouts.admin')

@section('page-title')
    Deployments Management
@endsection

@push('css-page')
    <style>
        .deployment-card {
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
        .status-transferred { background: #cce5ff; color: #004085; }
        .unit-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
        }
        .unit-mndf { background: #e2e3e5; color: #383d41; }
        .unit-police { background: #d1ecf1; color: #0c5460; }
        .unit-other { background: #fff3cd; color: #856404; }
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
                    <li class="breadcrumb-item active">Deployments</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Deployments</h5>
                <a href="{{ route('national-service-lms.deployments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create New Deployment
                </a>
            </div>
        </div>
    </div>

    <!-- Deployments List -->
    <div class="row">
        @forelse($deployments as $deployment)
        <div class="col-md-6 col-lg-4">
            <div class="deployment-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="mb-0">{{ $deployment->student->name ?? 'Unknown Student' }}</h5>
                    <span class="status-badge status-{{ $deployment->status }}">
                        {{ ucfirst($deployment->status) }}
                    </span>
                </div>

                <div class="mb-3">
                    <p class="mb-1"><strong>Unit:</strong>
                        <span class="unit-badge unit-{{ $deployment->unit }}">
                            {{ strtoupper($deployment->unit) }}
                        </span>
                    </p>
                    <p class="mb-1"><strong>Unit Name:</strong> {{ $deployment->unit_name }}</p>
                    <p class="mb-1"><strong>Position:</strong> {{ $deployment->position }}</p>
                    <p class="mb-1"><strong>Deployment Date:</strong>
                        @if($deployment->deployment_date)
                            {{ \Carbon\Carbon::parse($deployment->deployment_date)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                    @if($deployment->notes)
                        <p class="mb-1"><strong>Notes:</strong> {{ Str::limit($deployment->notes, 100) }}</p>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">Created: {{ $deployment->created_at->format('d/m/Y') }}</span>
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
                <h5>No deployments found</h5>
                <p>No deployments have been created yet.</p>
                <a href="{{ route('national-service-lms.deployments.create') }}" class="btn btn-primary mt-2">Create First Deployment</a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($deployments->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $deployments->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
