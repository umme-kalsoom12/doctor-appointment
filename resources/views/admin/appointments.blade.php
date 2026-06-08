<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments — MediCare Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0a6ebd; --secondary: #03c4a1; --dark: #0d1b2a; }
        body { font-family: 'DM Sans', sans-serif; background: #f4f9ff; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.07); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .topbar-brand { font-size: 1.4rem; font-weight: 700; color: var(--primary); }
        .topbar-brand span { color: var(--secondary); }
        .btn-logout { background: #ff4757; color: white; border: none; padding: 8px 18px; border-radius: 20px; font-size: 0.85rem; cursor: pointer; }
        .nav-link-custom { color: var(--dark); text-decoration: none; font-weight: 500; font-size: 0.9rem; padding: 6px 14px; border-radius: 20px; transition: all 0.2s; }
        .nav-link-custom:hover, .nav-link-custom.active { background: var(--primary); color: white; }
        .main { padding: 35px; }
        .page-title { font-size: 1.6rem; font-weight: 700; color: var(--dark); margin-bottom: 25px; }
        .appt-table { background: white; border-radius: 14px; box-shadow: 0 4px 18px rgba(0,0,0,0.06); overflow: hidden; }
        .appt-table th { background: var(--dark); color: white; font-weight: 500; font-size: 0.85rem; padding: 14px 16px; }
        .appt-table td { padding: 12px 16px; font-size: 0.85rem; vertical-align: middle; }
        .appt-table tr:hover { background: #f8fbff; }
        .badge-pending { background: #fff3cd; color: #856404; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-confirmed { background: #d1f3e8; color: #0a6640; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .badge-cancelled { background: #fde8e8; color: #c0392b; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
        .status-form select { border: 2px solid #e8f0fe; border-radius: 8px; padding: 5px 10px; font-size: 0.82rem; }
        .btn-update { background: var(--secondary); color: white; border: none; padding: 6px 14px; border-radius: 8px; font-size: 0.82rem; cursor: pointer; margin-left: 5px; }
        .btn-update:hover { background: #02a88a; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand"><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span> <small style="font-size:0.7rem; background:var(--primary); color:white; padding:2px 8px; border-radius:10px; margin-left:8px;">ADMIN</small></div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="/admin/dashboard" class="nav-link-custom"><i class="fas fa-th-large me-1"></i>Dashboard</a>
        <a href="/admin/doctors" class="nav-link-custom"><i class="fas fa-user-md me-1"></i>Doctors</a>
        <a href="/admin/appointments" class="nav-link-custom active"><i class="fas fa-calendar me-1"></i>Appointments</a>
        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
        </form>
    </div>
</div>

<div class="main">
    <div class="page-title"><i class="fas fa-calendar-alt me-2" style="color:var(--primary);"></i>Manage Appointments</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="appt-table">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Specialization</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $i => $appt)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><i class="fas fa-user me-1" style="color:var(--primary);"></i>{{ $appt->user->name }}</td>
                    <td>Dr. {{ $appt->doctor->name }}</td>
                    <td style="color:var(--secondary);">{{ $appt->doctor->specialization }}</td>
                    <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</td>
                    <td>{{ $appt->notes ?? '—' }}</td>
                    <td>
                        @if($appt->status == 'confirmed')
                            <span class="badge-confirmed">Confirmed</span>
                        @elseif($appt->status == 'cancelled')
                            <span class="badge-cancelled">Cancelled</span>
                        @else
                            <span class="badge-pending">Pending</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="/admin/appointments/{{ $appt->id }}/status" class="status-form d-flex align-items-center">
                            @csrf
                            <select name="status">
                                <option value="pending" {{ $appt->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $appt->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $appt->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn-update"><i class="fas fa-check"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">No appointments yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>