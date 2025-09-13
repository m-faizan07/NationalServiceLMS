@extends('layouts.admin')

@section('page-title')
    Create Deployment
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
                    <li class="breadcrumb-item"><a href="{{ route('national-service-lms.deployments') }}">Deployments</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    <div class="row">
        <div class="col-12">
            <div class="form-section">
                <h5 class="section-title">Deployment Information</h5>

                <form action="{{ route('national-service-lms.deployments.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Select Student <span class="text-danger">*</span></label>
                                <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                    <option value="">Choose a student...</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }} ({{ $student->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Only approved students are available for deployment</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                                <select name="unit" id="unit" class="form-select @error('unit') is-invalid @enderror" required>
                                    <option value="">Select unit...</option>
                                    <option value="mndf" {{ old('unit') == 'mndf' ? 'selected' : '' }}>MNDF (Maldives National Defence Force)</option>
                                    <option value="police" {{ old('unit') == 'police' ? 'selected' : '' }}>Police Service</option>
                                    <option value="other" {{ old('unit') == 'other' ? 'selected' : '' }}>Other Government Unit</option>
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unit_name" class="form-label">Unit Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('unit_name') is-invalid @enderror"
                                       id="unit_name" name="unit_name" value="{{ old('unit_name') }}" required>
                                @error('unit_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Specific name of the unit or department</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror"
                                       id="position" name="position" value="{{ old('position') }}" required>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Student's assigned position or role</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="deployment_date" class="form-label">Deployment Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('deployment_date') is-invalid @enderror"
                                       id="deployment_date" name="deployment_date" value="{{ old('deployment_date') }}" required>
                                @error('deployment_date')
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
                                    <option value="transferred" {{ old('status') == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                  id="notes" name="notes" rows="4"
                                  placeholder="Enter any additional notes about the deployment">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('national-service-lms.deployments') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Deployments
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Deployment
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
    // Set minimum date for deployment to today
    document.getElementById('deployment_date').min = new Date().toISOString().split('T')[0];

    // Auto-fill unit name based on unit selection
    document.getElementById('unit').addEventListener('change', function() {
        const unitNameField = document.getElementById('unit_name');
        const unit = this.value;

        if (unit === 'mndf') {
            unitNameField.value = 'Maldives National Defence Force';
        } else if (unit === 'police') {
            unitNameField.value = 'Maldives Police Service';
        } else if (unit === 'other') {
            unitNameField.value = '';
            unitNameField.placeholder = 'Enter specific unit name';
        }
    });
</script>
@endpush
