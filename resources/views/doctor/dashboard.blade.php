<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard — MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root { --primary: #03c4a1; --secondary: #0a6ebd; --dark: #0d1b2a; }
        body { font-family: 'Poppins', sans-serif; background: #f0f4f8; }
        .sidebar { width: 260px; background: #0a3d2e; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-brand h4 { color: white; font-weight: 700; font-size: 1.15rem; margin: 0; }
        .sidebar-brand h4 span { color: var(--primary); }
        .sidebar-brand p { color: rgba(255,255,255,0.4); font-size: 0.7rem; margin: 3px 0 0; }
        .sidebar-menu { padding: 10px 0; flex: 1; }
        .menu-label { color: rgba(255,255,255,0.25); font-size: 0.65rem; font-weight: 700; padding: 12px 20px 5px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 11px 20px; color: rgba(255,255,255,0.6); text-decoration: none; transition: all 0.2s; font-size: 0.83rem; border-left: 3px solid transparent; }
        .menu-item:hover, .menu-item.active { background: rgba(3,196,161,0.15); color: white; border-left-color: var(--primary); }
        .menu-item i { width: 18px; text-align: center; }
        .menu-badge { background: #ff4757; color: white; padding: 1px 7px; border-radius: 20px; font-size: 0.62rem; margin-left: auto; }
        .sidebar-footer { padding: 15px 20px; border-top: 1px solid rgba(255,255,255,0.08); }
        .user-avatar { width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; flex-shrink: 0; }
        .user-name { color: white; font-size: 0.8rem; font-weight: 600; }
        .user-role { color: rgba(255,255,255,0.4); font-size: 0.68rem; }
        .main { margin-left: 260px; }
        .topbar { background: white; padding: 14px 28px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 50; flex-wrap: wrap; gap: 10px; }
        .topbar-left h5 { font-weight: 700; color: var(--dark); font-size: 1.1rem; margin: 0; }
        .topbar-left p { color: #888; font-size: 0.72rem; margin: 1px 0 0; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .datetime-pill { background: #f4f7fb; padding: 7px 14px; border-radius: 10px; font-size: 0.75rem; color: #555; border: 2px solid #e8f0fe; }
        .btn-logout { background: #ff4757; color: white; border: none; padding: 8px 18px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; cursor: pointer; }
        .content { padding: 25px 28px; }
        .profile-card { background: linear-gradient(135deg, #0a3d2e, #03c4a1); border-radius: 18px; padding: 25px; color: white; margin-bottom: 22px; display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }
        .profile-avatar { width: 70px; height: 70px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; flex-shrink: 0; border: 3px solid rgba(255,255,255,0.4); }
        .profile-info h4 { font-weight: 700; font-size: 1.2rem; margin: 0; }
        .profile-info p { color: rgba(255,255,255,0.8); font-size: 0.8rem; margin: 4px 0 10px; }
        .profile-badges { display: flex; gap: 8px; flex-wrap: wrap; }
        .profile-badge { background: rgba(255,255,255,0.2); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 500; }
        .stat-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 15px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 15px; transition: all 0.2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; flex-shrink: 0; }
        .stat-icon.green { background: linear-gradient(135deg, #03c4a1, #02a88a); }
        .stat-icon.blue { background: linear-gradient(135deg, #0a6ebd, #1a8fe8); }
        .stat-icon.orange { background: linear-gradient(135deg, #ff6b35, #ff8c42); }
        .stat-icon.purple { background: linear-gradient(135deg, #6c5ce7, #a29bfe); }
        .stat-num { font-size: 1.5rem; font-weight: 700; color: var(--dark); line-height: 1; }
        .stat-label { color: #888; font-size: 0.72rem; margin-top: 3px; }
        .section-card { background: white; border-radius: 16px; padding: 22px; box-shadow: 0 2px 15px rgba(0,0,0,0.06); margin-top: 22px; }
        .section-title { font-weight: 700; color: var(--dark); font-size: 0.92rem; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
        .search-input { border: 2px solid #e8f0fe; border-radius: 10px; padding: 7px 12px; font-size: 0.82rem; width: 200px; outline: none; }
        .search-input:focus { border-color: var(--primary); }
        .table th { background: #0a3d2e; color: white; padding: 11px 14px; font-size: 0.78rem; font-weight: 500; }
        .table td { padding: 11px 14px; font-size: 0.78rem; vertical-align: middle; border-bottom: 1px solid #f0f4f8; }
        .table tr:hover td { background: #f0faf7; }
        .badge-pending { background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .badge-confirmed { background: #d1f3e8; color: #0a6640; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .badge-cancelled { background: #fde8e8; color: #c0392b; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .btn-approve { background: #d1f3e8; color: #0a6640; border: none; padding: 5px 12px; border-radius: 8px; font-size: 0.72rem; font-weight: 600; cursor: pointer; }
        .btn-approve:hover { background: #03c4a1; color: white; }
        .btn-reject { background: #fde8e8; color: #c0392b; border: none; padding: 5px 12px; border-radius: 8px; font-size: 0.72rem; font-weight: 600; cursor: pointer; margin-left: 4px; }
        .btn-reject:hover { background: #ff4757; color: white; }
        .schedule-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-bottom: 10px; background: #f0faf7; padding: 10px 12px; border-radius: 10px; }
        .schedule-row select, .schedule-row input[type=time] { border: 2px solid #d0eeea; border-radius: 8px; padding: 6px 10px; font-size: 0.8rem; outline: none; }
        .btn-add-row { background: #f0faf7; color: var(--primary); border: 2px dashed var(--primary); padding: 8px; border-radius: 10px; font-weight: 600; cursor: pointer; width: 100%; margin-top: 5px; font-size: 0.82rem; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 9px 22px; border-radius: 10px; font-weight: 600; margin-top: 12px; font-size: 0.82rem; }
        .day-badge { background: var(--primary); color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; }
        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; } }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></h4>
        <p>Doctor Portal</p>
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">Main</div>
        <a href="/doctor/dashboard" class="menu-item active"><i class="fas fa-th-large"></i>Dashboard</a>
        <div class="menu-label">Manage</div>
        <a href="#appointments" class="menu-item">
            <i class="fas fa-calendar-check"></i>Appointments
            @if(isset($pendingCount) && $pendingCount > 0)
                <span class="menu-badge">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="#schedule" class="menu-item"><i class="fas fa-clock"></i>My Schedule</a>
        <div class="menu-label">Account</div>
        <a href="#profile" class="menu-item"><i class="fas fa-user-md"></i>My Profile</a>
    </div>
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div class="user-avatar">
                @if(isset($doctor) && $doctor)
                    {{ strtoupper(substr($doctor->name, 0, 1)) }}
                @else
                    D
                @endif
            </div>
            <div>
                <div class="user-name">
                    @if(isset($doctor) && $doctor)
                        Dr. {{ $doctor->name }}
                    @else
                        Doctor
                    @endif
                </div>
                <div class="user-role">
                    @if(isset($doctor) && $doctor)
                        {{ $doctor->specialization }}
                    @else
                        Doctor
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <h5><i class="fas fa-th-large me-2" style="color:var(--primary);"></i>Doctor Dashboard</h5>
            <p id="dateDisplay"></p>
        </div>
        <div class="topbar-right">
            <div class="datetime-pill" id="timeDisplay"></div>
            <form method="POST" action="/logout" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
            </form>
        </div>
    </div>

    <div class="content">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:12px; font-size:0.83rem;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- PROFILE CARD -->
        <div class="profile-card" id="profile">
            <div class="profile-avatar"><i class="fas fa-user-md"></i></div>
            <div class="profile-info">
                @if(isset($doctor) && $doctor)
                <h4>Dr. {{ $doctor->name }}</h4>
                <p><i class="fas fa-envelope me-1"></i>{{ $doctor->email }}</p>
                <div class="profile-badges">
                    <span class="profile-badge"><i class="fas fa-stethoscope me-1"></i>{{ $doctor->specialization }}</span>
                    <span class="profile-badge"><i class="fas fa-briefcase me-1"></i>{{ $doctor->experience }} yrs</span>
                    <span class="profile-badge"><i class="fas fa-tag me-1"></i>Rs. {{ $doctor->fee }}</span>
                    <span class="profile-badge"><i class="fas fa-phone me-1"></i>{{ $doctor->phone }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- STATS -->
        <div class="row g-3 mb-3">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <div class="stat-num">{{ isset($appointments) ? $appointments->count() : 0 }}</div>
                        <div class="stat-label">Total Appointments</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <div class="stat-num">{{ isset($appointments) ? $appointments->where('status','confirmed')->count() : 0 }}</div>
                        <div class="stat-label">Confirmed</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="stat-num">{{ isset($pendingCount) ? $pendingCount : 0 }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="stat-num">{{ isset($appointments) ? $appointments->pluck('user_id')->unique()->count() : 0 }}</div>
                        <div class="stat-label">Total Patients</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- APPOINTMENTS -->
        <div class="section-card" id="appointments">
            <div class="section-title">
                <span>
                    <i class="fas fa-list me-2" style="color:var(--primary);"></i>Appointments
                    @if(isset($pendingCount) && $pendingCount > 0)
                    <span style="background:#ff4757; color:white; padding:2px 8px; border-radius:20px; font-size:0.68rem; margin-left:8px;">{{ $pendingCount }} Pending</span>
                    @endif
                </span>
                <input type="text" class="search-input" id="searchPatient" placeholder="🔍 Search patient..." onkeyup="searchTable()">
            </div>
            <div class="table-responsive">
                <table class="table table-borderless mb-0" id="apptTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($appointments) && $appointments->count() > 0)
                        @foreach($appointments as $i => $appt)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>
                                <div style="font-weight:600; color:var(--dark); font-size:0.8rem;">
                                    <i class="fas fa-user me-1" style="color:var(--primary);"></i>{{ $appt->user->name }}
                                </div>
                                <div style="font-size:0.7rem; color:#888;">{{ $appt->user->email }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</td>
                            <td style="max-width:130px; color:#666; font-size:0.75rem;">{{ $appt->notes ?? '—' }}</td>
                            <td>
                                @if($appt->status=='confirmed')
                                    <span class="badge-confirmed">✅ Confirmed</span>
                                @elseif($appt->status=='cancelled')
                                    <span class="badge-cancelled">❌ Rejected</span>
                                @else
                                    <span class="badge-pending">⏳ Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($appt->status == 'pending')
                                <form method="POST" action="/doctor/appointments/{{ $appt->id }}/approve" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-approve">✅ Approve</button>
                                </form>
                                <form method="POST" action="/doctor/appointments/{{ $appt->id }}/reject" style="display:inline;" id="rejectForm{{ $appt->id }}">
                                    @csrf
                                    <input type="hidden" name="reason" id="reason{{ $appt->id }}" value="">
                                    <button type="button" class="btn-reject" onclick="rejectAppt({{ $appt->id }})">❌ Reject</button>
                                </form>
                                @else
                                    <span style="color:#bbb; font-size:0.75rem;">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-2 d-block" style="color:#ddd;"></i>
                                No appointments yet
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SCHEDULE -->
        <div class="section-card" id="schedule">
            <div class="section-title">
                <span><i class="fas fa-calendar-alt me-2" style="color:var(--primary);"></i>My Schedule</span>
            </div>

            @if(isset($schedules) && $schedules->count() > 0)
            <div class="table-responsive mb-4">
                <table class="table table-borderless">
                    <thead><tr><th>Day</th><th>Start</th><th>End</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($schedules as $s)
                        <tr>
                            <td><span class="day-badge">{{ $s->day }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}</td>
                            <td>
                                @if($s->is_available)
                                    <span class="badge-confirmed">✅ Available</span>
                                @else
                                    <span class="badge-cancelled">❌ Unavailable</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <h6 style="font-weight:700; color:var(--dark); font-size:0.85rem; margin-bottom:12px;">
                <i class="fas fa-edit me-1"></i>Update Schedule:
            </h6>
            <form method="POST" action="/doctor/schedule">
                @csrf
                <div id="scheduleRows">
                    <div class="schedule-row">
                        <select name="day[]" required>
                            <option value="">Select Day</option>
                            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $d)
                            <option>{{ $d }}</option>
                            @endforeach
                        </select>
                        <input type="time" name="start_time[]" required>
                        <span style="color:#888; font-size:0.8rem;">to</span>
                        <input type="time" name="end_time[]" required>
                        <label style="font-size:0.8rem; display:flex; align-items:center; gap:5px; color:#555;">
                            <input type="checkbox" name="is_available[]" value="1" checked> Available
                        </label>
                    </div>
                </div>
                <button type="button" class="btn-add-row" onclick="addRow()">
                    <i class="fas fa-plus me-1"></i>Add Another Day
                </button>
                <br>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-1"></i>Save Schedule
                </button>
            </form>
        </div>

    </div>
</div>

<!-- REJECT MODAL -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; border:none;">
            <div class="modal-header" style="background:#fde8e8; border-radius:16px 16px 0 0;">
                <h6 class="modal-title" style="font-weight:700; color:#c0392b;">❌ Reject Appointment</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label style="font-weight:600; font-size:0.85rem; color:#333;">Rejection Reason:</label>
                <textarea id="rejectReason" class="form-control mt-2" rows="3"
                    placeholder="Reason likhein..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmReject()">Confirm Reject</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentRejectId = null;

function rejectAppt(id) {
    currentRejectId = id;
    document.getElementById('rejectReason').value = '';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function confirmReject() {
    const reason = document.getElementById('rejectReason').value || 'Doctor unavailable';
    document.getElementById('reason' + currentRejectId).value = reason;
    document.getElementById('rejectForm' + currentRejectId).submit();
}

function addRow() {
    const days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
    const opts = days.map(d => `<option>${d}</option>`).join('');
    const row = `<div class="schedule-row">
        <select name="day[]" required><option value="">Select Day</option>${opts}</select>
        <input type="time" name="start_time[]" required>
        <span style="color:#888; font-size:0.8rem;">to</span>
        <input type="time" name="end_time[]" required>
        <label style="font-size:0.8rem; display:flex; align-items:center; gap:5px; color:#555;">
            <input type="checkbox" name="is_available[]" value="1" checked> Available
        </label>
        <button type="button" onclick="this.parentElement.remove()"
            style="background:#fde8e8; color:#c0392b; border:none; padding:4px 10px; border-radius:8px; cursor:pointer;">
            <i class="fas fa-times"></i>
        </button>
    </div>`;
    document.getElementById('scheduleRows').insertAdjacentHTML('beforeend', row);
}

function searchTable() {
    const val = document.getElementById('searchPatient').value.toLowerCase();
    document.querySelectorAll('#apptTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
    });
}

function updateTime() {
    const now = new Date();
    const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const time = now.toLocaleTimeString('en-US', {hour:'2-digit', minute:'2-digit', second:'2-digit'});
    const date = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
    document.getElementById('timeDisplay').textContent = time;
    document.getElementById('dateDisplay').textContent = date;
}
updateTime();
setInterval(updateTime, 1000);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>