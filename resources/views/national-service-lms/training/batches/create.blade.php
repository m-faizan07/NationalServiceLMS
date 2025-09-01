@extends('layouts.admin')

@section('page-title')
    Create Training Batch
@endsection

@push('css-page')
    <style>
        .form-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }
        .section-title {
            color: #2c3e50;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
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
                    <li class="breadcrumb-item"><a href="{{ route('national-service-lms.training.batches') }}">Training Batches</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    <div class="row">
        <div class="col-12">
            <div class="form-section">
                <h5 class="section-title">Batch Information</h5>

                <form action="{{ route('national-service-lms.training.batches.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="batch_name" class="form-label">Batch Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('batch_name') is-invalid @enderror"
                                       id="batch_name" name="batch_name" value="{{ old('batch_name') }}" required>
                                @error('batch_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Enter a descriptive name for the training batch</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="batch_code" class="form-label">Batch Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('batch_code') is-invalid @enderror"
                                       id="batch_code" name="batch_code" value="{{ old('batch_code') }}" required>
                                @error('batch_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Unique identifier for the batch (e.g., NS2024-001)</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                       id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                       id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                       id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Maximum number of students that can enroll</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Enter batch description, objectives, or any additional information">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('national-service-lms.training.batches') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Batches
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Batch
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
    // Set minimum start date to today
    document.getElementById('start_date').min = new Date().toISOString().split('T')[0];

    // Update end date minimum when start date changes
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });

    // Validate end date is after start date
    document.getElementById('end_date').addEventListener('change', function() {
        const startDate = document.getElementById('start_date').value;
        if (startDate && this.value <= startDate) {
            alert('End date must be after start date');
            this.value = '';
        }
    });

    // Auto-generate batch code if empty
    document.getElementById('batch_name').addEventListener('blur', function() {
        const batchCodeField = document.getElementById('batch_code');
        if (!batchCodeField.value && this.value) {
            const year = new Date().getFullYear();
            const randomNum = Math.floor(Math.random() * 999) + 1;
            batchCodeField.value = `NS${year}-${randomNum.toString().padStart(3, '0')}`;
        }
    });
</script>
@endpush
