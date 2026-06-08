<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors — MediCare</title>
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
        .main { padding: 35px; }
        .search-box { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.07); margin-bottom: 30px; }
        .search-box h5 { font-weight: 700; color: var(--dark); margin-bottom: 18px; }
        .form-control, .form-select { border: 2px solid #e8f0fe; border-radius: 10px; padding: 10px 14px; font-size: 0.9rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: none; }
        .btn-search { background: var(--primary); color: white; border: none; padding: 11px 28px; border-radius: 10px; font-weight: 600; width: 100%; }
        .btn-search:hover { background: #085a9e; color: white; }
        .btn-reset { background: #f0f4ff; color: var(--dark); border: none; padding: 11px 28px; border-radius: 10px; font-weight: 600; width: 100%; text-decoration: none; display: block; text-align: center; }
        .btn-reset:hover { background: #e0e8ff; color: var(--dark); }
        .doctor-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.07); transition: all 0.3s; height: 100%; }
        .doctor-card:hover { transform: translateY(-6px); box-shadow: 0 14px 35px rgba(10,110,189,0.14); }
        .doc-img { height: 180px; background: linear-gradient(135deg, #e8f4ff, #d0eeea); display: flex; align-items: center; justify-content: center; font-size: 4rem; color: var(--primary); }
        .doc-body { padding: 18px; }
        .doc-name { font-weight: 700; font-size: 1.05rem; color: var(--dark); }
        .doc-spec { color: var(--secondary); font-size: 0.83rem; font-weight: 500; margin: 4px 0 10px; }
        .doc-meta { display: flex; justify-content: space-between; align-items: center; }
        .doc-exp { font-size: 0.82rem; color: #777; }
        .doc-fee { font-weight: 700; color: var(--primary); }
        .schedule-box { margin: 10px 0; padding: 10px; background: #f0f9f6; border-radius: 8px; }
        .schedule-box-title { font-size: 0.8rem; font-weight: 700; color: var(--dark); margin-bottom: 6px; }
        .schedule-tag { background: var(--secondary); color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.73rem; margin: 2px; display: inline-block; }
        .no-schedule { background: #fff3cd; color: #856404; padding: 8px 10px; border-radius: 8px; font-size: 0.8rem; margin: 10px 0; }
        .btn-book { background: var(--primary); color: white; border: none; padding: 10px 0; width: 100%; border-radius: 10px; font-weight: 600; margin-top: 12px; text-decoration: none; display: block; text-align: center; transition: background 0.3s; }
        .btn-book:hover { background: #085a9e; color: white; }
        .results-info { color: #666; font-size: 0.9rem; }
        .no-results { background: white; border-radius: 14px; padding: 60px; text-align: center; box-shadow: 0 4px 18px rgba(0,0,0,0.06); }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand"><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></div>
    <div class="d-flex gap-3 align-items-center flex-wrap">
        <a href="/" class="nav-link-custom"><i class="fas fa-home me-1"></i>Home</a>
        <a href="/dashboard" class="nav-link-custom"><i class="fas fa-th-large me-1"></i>Dashboard</a>
        <a href="/my-appointments" class="nav-link-custom"><i class="fas fa-calendar me-1"></i>My Appointments</a>
        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
        </form>
    </div>
</div>

<div class="main">

    {{-- SEARCH BOX --}}
    <div class="search-box">
        <h5><i class="fas fa-search me-2" style="color:var(--primary);"></i>Search Doctors</h5>
        <form method="GET" action="/doctors/search">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold" style="font-size:0.88rem;">Doctor Name</label>
                    <input type="text" name="name" class="form-control"
                        placeholder="Search by name..."
                        value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" style="font-size:0.88rem;">Specialization</label>
                    <select name="specialization" class="form-select">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>
                                {{ $spec }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold" style="font-size:0.88rem;">Max Fee (Rs.)</label>
                    <input type="number" name="max_fee" class="form-control"
                        placeholder="e.g. 2000"
                        value="{{ request('max_fee') }}">
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <a href="/doctors" class="btn-reset">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="font-weight:700; color:var(--dark);">
            <i class="fas fa-user-md me-2" style="color:var(--primary);"></i>Our Doctors
        </h4>
        <div class="results-info">
            <i class="fas fa-info-circle me-1"></i>{{ $doctors->count() }} doctor(s) found
        </div>
    </div>

    {{-- DOCTORS GRID --}}
    @if($doctors->count() > 0)
    <div class="row g-4">
        @foreach($doctors as $doctor)
        <div class="col-md-4 col-sm-6">
            <div class="doctor-card">
                <div class="doc-img"><i class="fas fa-user-md"></i></div>
                <div class="doc-body">
                    <div class="doc-name">Dr. {{ $doctor->name }}</div>
                    <div class="doc-spec">{{ $doctor->specialization }}</div>
                    <div class="doc-meta">
                        <span class="doc-exp"><i class="fas fa-briefcase me-1"></i>{{ $doctor->experience }} yrs</span>
                        <span class="doc-fee">Rs. {{ $doctor->fee }}</span>
                    </div>
                    <div class="doc-meta mt-1">
                        <span class="doc-exp"><i class="fas fa-phone me-1"></i>{{ $doctor->phone }}</span>
                    </div>

                    {{-- SCHEDULE --}}
                    @if($doctor->schedules && $doctor->schedules->where('is_available', 1)->count() > 0)
                    <div class="schedule-box">
                        <div class="schedule-box-title">
                            <i class="fas fa-calendar-check me-1" style="color:var(--secondary);"></i>Available Days:
                        </div>
                        @foreach($doctor->schedules->where('is_available', 1) as $schedule)
                        <span class="schedule-tag">
                            {{ $schedule->day }}
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                        </span>
                        @endforeach
                    </div>
                    @else
                    <div class="no-schedule">
                        <i class="fas fa-clock me-1"></i>Schedule not set yet
                    </div>
                    @endif

                    <a href="/book-appointment/{{ $doctor->id }}" class="btn-book">
                        <i class="fas fa-calendar-check me-2"></i>Book Appointment
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="no-results">
        <i class="fas fa-search fa-4x mb-3" style="color:#ddd; display:block;"></i>
        <h5 style="color:#aaa;">No doctors found!</h5>
        <p style="color:#bbb;">Try different search criteria.</p>
        <a href="/doctors" class="btn-book" style="width:auto; display:inline-block; padding:10px 25px;">
            Show All Doctors
        </a>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>