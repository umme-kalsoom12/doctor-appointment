<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments — MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #0a6ebd; --secondary: #03c4a1; --dark: #0d1b2a; }
        body { font-family: sans-serif; background: #f4f9ff; }
        .topbar { background: white; padding: 15px 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.07); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .topbar-brand { font-size: 1.4rem; font-weight: 700; color: var(--primary); }
        .topbar-brand span { color: var(--secondary); }
        .btn-logout { background: #ff4757; color: white; border: none; padding: 8px 18px; border-radius: 20px; font-size: 0.85rem; cursor: pointer; }
        .nav-link-custom { color: var(--dark); text-decoration: none; font-weight: 500; font-size: 0.9rem; padding: 6px 14px; border-radius: 20px; }
        .nav-link-custom:hover { background: var(--primary); color: white; }
        .main { padding: 35px; max-width: 900px; margin: 0 auto; }
        .appt-card { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 4px 18px rgba(0,0,0,0.06); margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; border-left: 4px solid var(--primary); }
        .appt-doc { font-weight: 700; color: var(--dark); font-size: 1rem; }
        .appt-spec { color: var(--secondary); font-size: 0.83rem; margin-top: 3px; }
        .appt-meta { color: #666; font-size: 0.85rem; margin-top: 8px; }
        .badge-pending { background: #fff3cd; color: #856404; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .badge-confirmed { background: #d1f3e8; color: #0a6640; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .badge-cancelled { background: #fde8e8; color: #c0392b; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .empty-box { background: white; border-radius: 14px; padding: 60px; text-align: center; box-shadow: 0 4px 18px rgba(0,0,0,0.06); }
        .btn-book-now { background: var(--primary); color: white; padding: 11px 28px; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block; }
        .btn-book-now:hover { background: #085a9e; color: white; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand"><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></div>
    <div class="d-flex gap-3 align-items-center flex-wrap">
        <a href="/" class="nav-link-custom"><i class="fas fa-home me-1"></i>Home</a>
        <a href="/dashboard" class="nav-link-custom"><i class="fas fa-th-large me-1"></i>Dashboard</a>
        <a href="/doctors" class="nav-link-custom"><i class="fas fa-user-md me-1"></i>Doctors</a>
        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
        </form>
    </div>
</div>

<div class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 style="font-weight:700; color:var(--dark);">
            <i class="fas fa-calendar-alt me-2" style="color:var(--primary);"></i>My Appointments
        </h4>
        <a href="/doctors" class="btn-book-now"><i class="fas fa-plus me-2"></i>Book New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($appointments as $appt)
    <div class="appt-card">
        <div>
            <div class="appt-doc">
                <i class="fas fa-user-md me-2" style="color:var(--primary);"></i>Dr. {{ $appt->doctor->name }}
            </div>
            <div class="appt-spec">{{ $appt->doctor->specialization }}</div>
            <div class="appt-meta">
                <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}
                &nbsp;&nbsp;
                <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                &nbsp;&nbsp;
                <i class="fas fa-tag me-1"></i>Rs. {{ $appt->doctor->fee }}
            </div>
            @if($appt->notes)
                <div class="appt-meta"><i class="fas fa-sticky-note me-1"></i>{{ $appt->notes }}</div>
            @endif
        </div>
        <div>
            @if($appt->status == 'confirmed')
                <span class="badge-confirmed"><i class="fas fa-check me-1"></i>Confirmed</span>
            @elseif($appt->status == 'cancelled')
                <span class="badge-cancelled"><i class="fas fa-times me-1"></i>Cancelled</span>
            @else
                <span class="badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-box">
        <i class="fas fa-calendar-times fa-4x mb-3" style="color:#ddd; display:block;"></i>
        <h5 style="color:#aaa;">No appointments yet!</h5>
        <p style="color:#bbb;">Book your first appointment today.</p>
        <a href="/doctors" class="btn-book-now mt-2">Book Now</a>
    </div>
    @endforelse
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>