<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root { --primary: #0a6ebd; --secondary: #03c4a1; --dark: #0d1b2a; }
        body { font-family: 'Poppins', sans-serif; background: #f0f4f8; }
        .sidebar { width: 250px; background: var(--dark); min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; padding: 25px 0; }
        .sidebar-brand { padding: 0 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand h4 { color: white; font-weight: 700; font-size: 1.2rem; }
        .sidebar-brand h4 span { color: var(--secondary); }
        .sidebar-brand p { color: rgba(255,255,255,0.5); font-size: 0.75rem; margin-top: 3px; }
        .sidebar-menu { padding: 20px 0; }
        .menu-label { color: rgba(255,255,255,0.3); font-size: 0.7rem; font-weight: 600; padding: 0 20px; margin: 15px 0 5px; text-transform: uppercase; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: rgba(255,255,255,0.65); text-decoration: none; transition: all 0.2s; font-size: 0.88rem; }
        .menu-item:hover, .menu-item.active { background: rgba(255,255,255,0.08); color: white; border-left: 3px solid var(--secondary); }
        .menu-item i { width: 18px; text-align: center; }
        .sidebar-user { padding: 20px; border-top: 1px solid rgba(255,255,255,0.1); position: absolute; bottom: 0; width: 100%; }
        .user-avatar { width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; }
        .user-name { color: white; font-size: 0.85rem; font-weight: 600; }
        .user-role { color: rgba(255,255,255,0.4); font-size: 0.72rem; }
        .main { margin-left: 250px; padding: 30px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .topbar h5 { font-weight: 700; color: var(--dark); font-size: 1.3rem; }
        .btn-logout { background: #ff4757; color: white; border: none; padding: 8px 20px; border-radius: 20px; font-size: 0.82rem; font-weight: 600; cursor: pointer; }
        .welcome-banner { background: linear-gradient(135deg, var(--dark), #1a3a5c); border-radius: 18px; padding: 28px; color: white; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .welcome-banner h4 { font-weight: 700; font-size: 1.4rem; }
        .welcome-banner p { color: rgba(255,255,255,0.7); font-size: 0.85rem; margin: 5px 0 0; }
        .admin-badge { background: var(--secondary); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
        .stat-card { background: white; border-radius: 16px; padding: 22px; box-shadow: 0 2px 15px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 15px; transition: all 0.2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: white; flex-shrink: 0; }
        .stat-icon.blue { background: linear-gradient(135deg, #0a6ebd, #1a8fe8); }
        .stat-icon.green { background: linear-gradient(135deg, #03c4a1, #02a88a); }
        .stat-icon.orange { background: linear-gradient(135deg, #ff6b35, #ff8c42); }
        .stat-icon.red { background: linear-gradient(135deg, #ff4757, #ff6b81); }
        .stat-num { font-size: 1.6rem; font-weight: 700; color: var(--dark); line-height: 1; }
        .stat-label { color: #888; font-size: 0.78rem; margin-top: 3px; }
        .section-card { background: white; border-radius: 16px; padding: 22px; box-shadow: 0 2px 15px rgba(0,0,0,0.06); margin-top: 22px; }
        .section-title { font-weight: 700; color: var(--dark); font-size: 1rem; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center; }
        .table th { background: var(--dark); color: white; padding: 12px 15px; font-size: 0.82rem; font-weight: 500; }
        .table td { padding: 11px 15px; font-size: 0.82rem; vertical-align: middle; }
        .table tr:hover td { background: #f8fbff; }
        .badge-pending { background: #fff3cd; color: #856404; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-confirmed { background: #d1f3e8; color: #0a6640; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-cancelled { background: #fde8e8; color: #c0392b; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .quick-link { background: white; border-radius: 14px; padding: 20px; text-align: center; box-shadow: 0 2px 15px rgba(0,0,0,0.06); text-decoration: none; transition: all 0.2s; display: block; }
        .quick-link:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .quick-link i { font-size: 2rem; margin-bottom: 8px; display: block; }
        .quick-link span { font-size: 0.85rem; font-weight: 600; color: var(--dark); }
        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; } }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></h4>
        <p>Admin Portal</p>
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">Main</div>
        <a href="/admin/dashboard" class="menu-item active"><i class="fas fa-th-large"></i>Dashboard</a>
        <div class="menu-label">Manage</div>
        <a href="/admin/doctors" class="menu-item"><i class="fas fa-user-md"></i>Doctors</a>
        <a href="/admin/appointments" class="menu-item"><i class="fas fa-calendar-check"></i>Appointments</a>
    </div>
    <div class="sidebar-user">
        <div class="d-flex align-items-center gap-2">
            <div class="user-avatar"><i class="fas fa-shield-alt" style="font-size:0.9rem;"></i></div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN -->
<div class="main">
    <div class="topbar">
        <h5><i class="fas fa-tachometer-alt me-2" style="color:var(--primary);"></i>Admin Dashboard</h5>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
        </form>
    </div>

    <!-- WELCOME -->
    <div class="welcome-banner">
        <div>
            <h4>Welcome, {{ auth()->user()->name }}! 🛡️</h4>
            <p>Manage your complete MediCare system from here.</p>
        </div>
        <span class="admin-badge"><i class="fas fa-shield-alt me-1"></i>Administrator</span>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-3">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-user-md"></i></div>
                <div>
                    <div class="stat-num">{{ $totalDoctors }}</div>
                    <div class="stat-label">Total Doctors</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-num">{{ $totalPatients }}</div>
                    <div class="stat-label">Total Patients</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-calendar-check"></i></div>
                <div>
                    <div class="stat-num">{{ $totalAppointments }}</div>
                    <div class="stat-label">Appointments</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon red"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="stat-num">{{ $pendingAppointments }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK LINKS -->
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <a href="/admin/doctors" class="quick-link">
                <i class="fas fa-user-md" style="color:#0a6ebd;"></i>
                <span>Manage Doctors</span>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/admin/appointments" class="quick-link">
                <i class="fas fa-calendar-check" style="color:#03c4a1;"></i>
                <span>Manage Appointments</span>
            </a>
        </div>
        <div class="col-md-4">
            <a href="/admin/appointments" class="quick-link">
                <i class="fas fa-clock" style="color:#ff6b35;"></i>
                <span>Pending Appointments</span>
            </a>
        </div>
    </div>

    <!-- RECENT APPOINTMENTS -->
    <div class="section-card">
        <div class="section-title">
            <span><i class="fas fa-list me-2" style="color:var(--primary);"></i>Recent Appointments</span>
            <a href="/admin/appointments" style="font-size:0.82rem; color:var(--primary); text-decoration:none;">View All →</a>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr><th>#</th><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($recentAppointments as $i => $appt)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td><i class="fas fa-user me-1" style="color:var(--primary);"></i>{{ $appt->user->name }}</td>
                        <td>Dr. {{ $appt->doctor->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</td>
                        <td>
                            @if($appt->status=='confirmed') <span class="badge-confirmed">Confirmed</span>
                            @elseif($appt->status=='cancelled') <span class="badge-cancelled">Cancelled</span>
                            @else <span class="badge-pending">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No appointments yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>