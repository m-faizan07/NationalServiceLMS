@extends('layouts.admin')

@section('page-title')
    Create Certificate Program
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
                <h4 class="page-title">Create Certificate Program</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('national-service-lms.dashboard') }}">National Service LMS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('national-service-lms.certificates.programs') }}">Certificate Programs</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    <div class="row">
        <div class="col-12">
            <div class="form-section">
                <h5 class="section-title">Program Information</h5>

                <form action="{{ route('national-service-lms.certificates.programs.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="program_name" class="form-label">Program Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('program_name') is-invalid @enderror"
                                       id="program_name" name="program_name" value="{{ old('program_name') }}" required>
                                @error('program_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration_months" class="form-label">Duration (Months) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('duration_months') is-invalid @enderror"
                                       id="duration_months" name="duration_months" value="{{ old('duration_months') }}" min="1" required>
                                @error('duration_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cost" class="form-label">Cost <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror"
                                           id="cost" name="cost" value="{{ old('cost') }}" min="0" step="0.01" required>
                                </div>
                                @error('cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Enter program description, objectives, and requirements">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('national-service-lms.certificates.programs') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Programs
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Program
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
    // Auto-format cost input
    document.getElementById('cost').addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
</script>
@endpush
