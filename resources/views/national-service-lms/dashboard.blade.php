@extends('layouts.admin')


@push('css-page')
    <style>
        :root {
            --bg: #f6f7fb;
            --card: #ffffff;
            --text: #1f2937; /* slate-800 */
            --muted: #64748b; /* slate-500 */
            --primary: #6c5ce7; /* indigo/violet */
            --primary-2: #7c3aed; /* violet-600 */
            --accent: #22c55e; /* green-500 */
            --accent-2: #06b6d4; /* cyan-500 */
            --warning: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --ring: rgba(124,58,237,.2);
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .dark {
            --bg: #0b1020;
            --card: #0f172a; /* slate-900 */
            --text: #e5e7eb; /* slate-200 */
            --muted: #94a3b8; /* slate-400 */
            --primary: #8b5cf6;
            --primary-2: #a78bfa;
            --accent: #22c55e;
            --accent-2: #06b6d4;
            --warning: #fbbf24;
            --success: #34d399;
            --danger: #f87171;
            --ring: rgba(167,139,250,.25);
            --shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
        }

        html, body { height: 100%; }
        body {
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            font-smooth: always;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Page chrome */
        .page-title-box .breadcrumb {
            background: transparent;
            margin-bottom: 0;
        }

        /* Utility */
        .soft-card {
            background: var(--card);
            border-radius: 16px;
            padding: 22px 20px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(124,58,237,.08);
        }
        .section-title {
            color: var(--primary);
            font-weight: 800;
            letter-spacing: .3px;
            margin-bottom: 18px;
            position: relative;
        }
        .section-title:after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 56px;
            height: 3px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--primary), var(--primary-2));
        }

        /* Stat grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 14px;
        }
        @media (max-width: 1199px) { .stat-grid { grid-template-columns: repeat(3, 1fr);} }
        @media (max-width: 767px)  { .stat-grid { grid-template-columns: repeat(2, 1fr);} }
        @media (max-width: 480px)  { .stat-grid { grid-template-columns: 1fr;} }

        .stat-card {
            background: radial-gradient(1200px 300px at 0% -20%, rgba(124,58,237,.12), transparent), var(--card);
            border: 1px solid rgba(124,58,237,.12);
            border-radius: 16px;
            padding: 18px 16px;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
            border-color: rgba(124,58,237,.25);
        }
        .stat-kpi { font-size: 1.8rem; font-weight: 800; letter-spacing: .3px; }
        .stat-label { color: var(--muted); font-weight: 600; margin-top: 4px; }
        .stat-pill {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: .825rem; font-weight: 700; border-radius: 999px; padding: 6px 10px;
            background: rgba(34,197,94,.10); color: var(--accent);
        }

        /* Quick actions */
        .quick-actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .quick-action-btn {
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            color: #fff;
            border: none;
            padding: 12px 16px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 10px;
            font-weight: 700; font-size: 1rem;
            box-shadow: 0 6px 18px rgba(6,182,212,.15);
            transition: transform .15s ease, box-shadow .2s ease;
        }
        .quick-action-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(6,182,212,.22); }
        .quick-action-btn i { font-size: 1.1rem; }

        /* Recent activities */
        .activity-item { padding: 12px 0; border-bottom: 1px dashed rgba(148,163,184,.35); }
        .activity-item:last-child { border-bottom: 0; }
        .activity-time { color: var(--muted); font-size: .9rem; font-weight: 600; }
        .status-badge { padding: 6px 12px; border-radius: 999px; font-size: .82rem; font-weight: 800; letter-spacing: .2px; }
        .status-pending { background: rgba(245,158,11,.16); color: var(--warning); }
        .status-approved { background: rgba(16,185,129,.16); color: var(--success); }
        .status-rejected { background: rgba(239,68,68,.16); color: var(--danger); }
        .status-interview { background: rgba(99,102,241,.18); color: var(--primary-2); }

        /* Top toolbar */
        .toolbar { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .toolbar .tools { display:flex; align-items:center; gap:10px; }
        .chip {
            display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:999px; font-weight:700; font-size:.9rem;
            background: linear-gradient(90deg, var(--primary), var(--primary-2)); color:#fff; box-shadow: var(--shadow);
        }
        .toggle {
            display:inline-flex; align-items:center; gap:8px; padding:6px 10px; border-radius:12px; border:1px solid rgba(124,58,237,.25);
            cursor:pointer; user-select:none; color: var(--muted); background: var(--card);
        }
        .toggle input { display:none; }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="soft-card" role="region" aria-label="Page header">
                <div class="toolbar">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">National Service LMS</li>
                            </ol>
                        </nav>
                        <h4 class="mb-0" style="font-weight:800; letter-spacing:.2px;">Dashboard</h4>
                    </div>
                    <div class="tools">
                        <span class="chip" title="Auto refresh every 5 min"><i class="fas fa-sync-alt"></i>&nbsp;Live</span>
                        <label class="toggle" id="themeToggle" title="Toggle dark mode">
                            <i class="far fa-moon"></i>
                            <span>Theme</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="soft-card">
                <h5 class="section-title">Quick Actions</h5>
                <div class="quick-actions">
                    <a href="{{ route('national-service-lms.students') }}" class="quick-action-btn"><i class="fas fa-users"></i>View Students</a>
                    <a href="{{ route('national-service-lms.training.batches.create') }}" class="quick-action-btn"><i class="fas fa-plus"></i>Create Training Batch</a>
                    <a href="{{ route('national-service-lms.interviews') }}" class="quick-action-btn"><i class="fas fa-calendar-alt"></i>Schedule Interview</a>
                    <a href="{{ route('national-service-lms.deployments.create') }}" class="quick-action-btn"><i class="fas fa-user-tie"></i>Create Deployment</a>
                    <a href="{{ route('national-service-lms.reports') }}" class="quick-action-btn"><i class="fas fa-chart-bar"></i>Reports</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Applicant Screening & Interview Process -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="soft-card">
                <h5 class="section-title">Applicant Screening & Interview Process</h5>
                <div class="stat-grid" role="grid" aria-label="Applicant metrics">
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['total_applications'] }}</div>
                        <div class="stat-label">Total Applications</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['pending_review'] }}</div>
                        <div class="stat-label">Pending Review</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['approved_for_interview'] }}</div>
                        <div class="stat-label">Approved for Interview</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['interview_scheduled'] }}</div>
                        <div class="stat-label">Interview Scheduled</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['interview_completed'] }}</div>
                        <div class="stat-label">Interview Completed</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['application_rejected'] }}</div>
                        <div class="stat-label">Application Rejected</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- National Service Training Management -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="soft-card">
                <h5 class="section-title">National Service Training Management</h5>
                <div class="stat-grid" role="grid" aria-label="Training metrics">
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['active_batches'] }}</div>
                        <div class="stat-label">Active Batches</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['students_not_reachable'] }}</div>
                        <div class="stat-label">Students Not Reachable</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['graduated_from_training'] }}</div>
                        <div class="stat-label">Graduated from Training</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['awaiting_training'] }}</div>
                        <div class="stat-label">Awaiting Training</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['currently_in_training'] }}</div>
                        <div class="stat-label">Currently in Training</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['training_terminated'] }}</div>
                        <div class="stat-label">Training Terminated</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Post Graduation Deployment -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="soft-card">
                <h5 class="section-title">Post Graduation Deployment</h5>
                <div class="stat-grid" role="grid" aria-label="Deployment metrics">
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['deployed_to_mndf'] }}</div>
                        <div class="stat-label">Deployed to MNDF</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['deployed_to_police'] }}</div>
                        <div class="stat-label">Deployed to Police</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['deployed_to_other_units'] }}</div>
                        <div class="stat-label">Other Units</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['certificate_programs'] }}</div>
                        <div class="stat-label">Certificate Programs</div>
                    </div>
                    <div class="stat-card" role="gridcell">
                        <div class="stat-kpi">{{ $data['under_age_18'] }}</div>
                        <div class="stat-label">Under Age 18</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Control Center & Recent Activities -->
    <div class="row mb-3">
        <!-- Control Center -->
        <div class="col-md-6">
            <div class="soft-card h-100">
                <h5 class="section-title">Control Center</h5>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-card text-center">
                            <div class="stat-kpi">{{ $data['active_users'] }}</div>
                            <div class="stat-label">Active Users</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card text-center">
                            <div class="stat-kpi">{{ $data['active_students'] }}</div>
                            <div class="stat-label">Active Students</div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="stat-pill" title="Users currently online"><i class="fas fa-signal"></i> Realtime</span>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-md-6">
            <div class="soft-card h-100">
                <h5 class="section-title">Recent Activities</h5>
                <div class="recent-activities" aria-live="polite">
                    @forelse($data['recent_applications']->take(5) as $student)
                        <div class="activity-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $student->name }}</strong> – New application submitted
                                    <span class="status-badge status-pending">Pending</span>
                                </div>
                                <span class="activity-time">{{ $student->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No recent applications.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Interviews and Deployments -->
    <div class="row mb-3">
        <!-- Recent Interviews -->
        <div class="col-md-6">
            <div class="soft-card h-100">
                <h5 class="section-title">Recent Interviews</h5>
                <div class="recent-activities">
                    @forelse($data['recent_interviews']->take(5) as $interview)
                        <div class="activity-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $interview->student->name }}</strong> – Interview {{ $interview->status }}
                                    @if($interview->result)
                                        <span class="status-badge status-{{ $interview->result === 'pass' ? 'approved' : ($interview->result === 'fail' ? 'rejected' : 'pending') }}">
                                            {{ ucfirst($interview->result) }}
                                        </span>
                                    @endif
                                </div>
                                <span class="activity-time">{{ $interview->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No recent interviews.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Deployments -->
        <div class="col-md-6">
            <div class="soft-card h-100">
                <h5 class="section-title">Recent Deployments</h5>
                <div class="recent-activities">
                    @forelse($data['recent_deployments']->take(5) as $deployment)
                        <div class="activity-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $deployment->student->name }}</strong> – Deployed to {{ ucfirst($deployment->unit) }}
                                    <span class="status-badge status-approved">{{ ucfirst($deployment->status) }}</span>
                                </div>
                                <span class="activity-time">{{ $deployment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No recent deployments.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script>
    // Auto-refresh dashboard data every 5 minutes (300000 ms)
    setInterval(function() { location.reload(); }, 300000);

    // Theme toggle (persists to localStorage)
    (function() {
        const root = document.documentElement;
        const saved = localStorage.getItem('theme');
        if (saved === 'dark') root.classList.add('dark');
        const toggle = document.getElementById('themeToggle');
        if (toggle) {
            toggle.addEventListener('click', () => {
                root.classList.toggle('dark');
                localStorage.setItem('theme', root.classList.contains('dark') ? 'dark' : 'light');
            });
        }
    })();
</script>
@endpush
