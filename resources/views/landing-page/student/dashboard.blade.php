<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
</html>