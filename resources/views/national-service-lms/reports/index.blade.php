@extends('layouts.admin')

@section('page-title')
    Reports & Analytics
@endsection

@push('css-page')
    <style>
        .report-section {
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
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .stat-card h3 {
            color: white;
            font-size: 2.5rem;
            margin: 0;
            font-weight: bold;
        }
        .stat-card p {
            color: rgba(255,255,255,0.9);
            margin: 5px 0 0 0;
            font-size: 1.1rem;
        }
        .chart-container {
            height: 300px;
            margin: 20px 0;
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
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Monthly Applications Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="report-section">
                <h5 class="section-title">Monthly Applications ({{ date('Y') }})</h5>
                <div class="chart-container">
                    <canvas id="monthlyApplicationsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Stages Distribution -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="report-section">
                <h5 class="section-title">Application Stages Distribution</h5>
                <div class="chart-container">
                    <canvas id="applicationStagesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="report-section">
                <h5 class="section-title">Deployment by Unit</h5>
                <div class="chart-container">
                    <canvas id="deploymentByUnitChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <h3>{{ $monthlyApplications->sum('count') }}</h3>
                <p>Total Applications This Year</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $applicationStages->where('application_stage', 'pending')->first()->count ?? 0 }}</h3>
                <p>Pending Applications</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $applicationStages->where('application_stage', 'approved')->first()->count ?? 0 }}</h3>
                <p>Approved Applications</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>{{ $deploymentByUnit->sum('count') }}</h3>
                <p>Total Deployments</p>
            </div>
        </div>
    </div>

    <!-- Detailed Reports -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="report-section">
                <h5 class="section-title">Application Stages Breakdown</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Stage</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = $applicationStages->sum('count') @endphp
                            @foreach($applicationStages as $stage)
                            <tr>
                                <td>{{ str_replace('_', ' ', ucfirst($stage->application_stage)) }}</td>
                                <td>{{ $stage->count }}</td>
                                <td>{{ $total > 0 ? round(($stage->count / $total) * 100, 1) : 0 }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="report-section">
                <h5 class="section-title">Deployment Units Breakdown</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Unit</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalDeployments = $deploymentByUnit->sum('count') @endphp
                            @foreach($deploymentByUnit as $deployment)
                            <tr>
                                <td>{{ strtoupper($deployment->unit) }}</td>
                                <td>{{ $deployment->count }}</td>
                                <td>{{ $totalDeployments > 0 ? round(($deployment->count / $totalDeployments) * 100, 1) : 0 }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="report-section">
                <h5 class="section-title">Monthly Application Trends</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Applications</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyApplications as $month)
                            <tr>
                                <td>{{ date('F', mktime(0, 0, 0, $month->month, 1)) }}</td>
                                <td>{{ $month->count }}</td>
                                <td>
                                    @if($month->count > 0)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">No Applications</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Applications Chart
    const monthlyCtx = document.getElementById('monthlyApplicationsChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyApplications->pluck('month')->map(function($month) { return date('F', mktime(0, 0, 0, $month, 1)); })) !!},
            datasets: [{
                label: 'Applications',
                data: {!! json_encode($monthlyApplications->pluck('count')) !!},
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Application Stages Chart
    const stagesCtx = document.getElementById('applicationStagesChart').getContext('2d');
    const stagesChart = new Chart(stagesCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($applicationStages->pluck('application_stage')->map(function($stage) { return str_replace('_', ' ', ucfirst($stage)); })) !!},
            datasets: [{
                data: {!! json_encode($applicationStages->pluck('count')) !!},
                backgroundColor: [
                    '#667eea',
                    '#f093fb',
                    '#4facfe',
                    '#43e97b',
                    '#fa709a',
                    '#ff9a9e'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Deployment by Unit Chart
    const deploymentCtx = document.getElementById('deploymentByUnitChart').getContext('2d');
    const deploymentChart = new Chart(deploymentCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($deploymentByUnit->pluck('unit')->map(function($unit) { return strtoupper($unit); })) !!},
            datasets: [{
                label: 'Deployments',
                data: {!! json_encode($deploymentByUnit->pluck('count')) !!},
                backgroundColor: [
                    '#667eea',
                    '#f093fb',
                    '#4facfe'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush
