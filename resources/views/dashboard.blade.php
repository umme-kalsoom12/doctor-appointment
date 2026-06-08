<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Patient Dashboard — MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root { --primary: #0a6ebd; --secondary: #03c4a1; --dark: #0d1b2a; --ai: #6c5ce7; }
        body { font-family: 'Poppins', sans-serif; background: #f0f4f8; }
        .sidebar { width: 250px; background: var(--dark); min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-brand h4 { color: white; font-weight: 700; font-size: 1.15rem; margin: 0; }
        .sidebar-brand h4 span { color: var(--secondary); }
        .sidebar-brand p { color: rgba(255,255,255,0.4); font-size: 0.7rem; margin: 3px 0 0; }
        .sidebar-menu { padding: 10px 0; flex: 1; }
        .menu-label { color: rgba(255,255,255,0.25); font-size: 0.65rem; font-weight: 700; padding: 12px 20px 5px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 11px 20px; color: rgba(255,255,255,0.6); text-decoration: none; transition: all 0.2s; font-size: 0.83rem; border-left: 3px solid transparent; }
        .menu-item:hover, .menu-item.active { background: rgba(255,255,255,0.07); color: white; border-left-color: var(--secondary); }
        .menu-item i { width: 18px; text-align: center; }
        .sidebar-footer { padding: 15px 20px; border-top: 1px solid rgba(255,255,255,0.08); }
        .user-avatar { width: 38px; height: 38px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; flex-shrink: 0; font-size: 1rem; }
        .user-name { color: white; font-size: 0.8rem; font-weight: 600; }
        .user-role { color: rgba(255,255,255,0.4); font-size: 0.68rem; }
        .main { margin-left: 250px; }
        .topbar { background: white; padding: 14px 28px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 50; flex-wrap: wrap; gap: 10px; }
        .topbar h5 { font-weight: 700; color: var(--dark); font-size: 1.1rem; margin: 0; }
        .topbar p { color: #888; font-size: 0.72rem; margin: 1px 0 0; }
        .btn-logout { background: #ff4757; color: white; border: none; padding: 8px 18px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; cursor: pointer; }
        .content { padding: 25px 28px; }
        .welcome-banner { background: linear-gradient(135deg, var(--primary), #1a8fe8); border-radius: 18px; padding: 25px; color: white; margin-bottom: 22px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .welcome-banner h4 { font-weight: 700; font-size: 1.3rem; margin: 0; }
        .welcome-banner p { color: rgba(255,255,255,0.8); font-size: 0.82rem; margin: 4px 0 0; }
        .btn-book-appt { background: white; color: var(--primary); padding: 9px 20px; border-radius: 25px; font-weight: 700; text-decoration: none; font-size: 0.82rem; white-space: nowrap; }
        .stat-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 15px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 15px; }
        .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; flex-shrink: 0; }
        .stat-icon.blue { background: linear-gradient(135deg, #0a6ebd, #1a8fe8); }
        .stat-icon.green { background: linear-gradient(135deg, #03c4a1, #02a88a); }
        .stat-icon.orange { background: linear-gradient(135deg, #ff6b35, #ff8c42); }
        .stat-num { font-size: 1.5rem; font-weight: 700; color: var(--dark); line-height: 1; }
        .stat-label { color: #888; font-size: 0.72rem; margin-top: 3px; }
        .section-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 15px rgba(0,0,0,0.06); }
        .section-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .section-head h6 { font-weight: 700; color: var(--dark); font-size: 0.92rem; margin: 0; }
        .appt-card { background: #f8fbff; border-radius: 12px; padding: 15px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; border-left: 4px solid var(--primary); }
        .appt-doc { font-weight: 700; color: var(--dark); font-size: 0.88rem; }
        .appt-spec { color: var(--secondary); font-size: 0.75rem; margin-top: 2px; }
        .appt-meta { color: #777; font-size: 0.75rem; margin-top: 5px; }
        .badge-pending { background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .badge-confirmed { background: #d1f3e8; color: #0a6640; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .badge-cancelled { background: #fde8e8; color: #c0392b; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .btn-cancel-appt { background: #fde8e8; color: #c0392b; border: none; padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 600; cursor: pointer; margin-top: 5px; }
        .notif-card { border-radius: 12px; padding: 14px 18px; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .notif-confirmed { background: #d1f3e8; border-left: 4px solid #03c4a1; }
        .notif-cancelled { background: #fde8e8; border-left: 4px solid #ff4757; }
        .ai-card { background: white; border-radius: 16px; padding: 22px; box-shadow: 0 2px 15px rgba(0,0,0,0.06); border-top: 4px solid var(--ai); }
        .ai-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .ai-icon { width: 45px; height: 45px; background: linear-gradient(135deg, #6c5ce7, #a29bfe); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; }
        .ai-badge { background: linear-gradient(135deg, #6c5ce7, #a29bfe); color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.65rem; font-weight: 700; margin-left: auto; }
        .ai-textarea { width: 100%; border: 2px solid #e8f0fe; border-radius: 12px; padding: 12px; font-size: 0.83rem; font-family: 'Poppins', sans-serif; resize: none; outline: none; transition: border 0.3s; }
        .ai-textarea:focus { border-color: var(--ai); }
        .btn-ai { background: linear-gradient(135deg, #6c5ce7, #a29bfe); color: white; border: none; padding: 12px 20px; border-radius: 12px; font-weight: 600; font-size: 0.83rem; cursor: pointer; width: 100%; }
        .btn-clear { background: #f4f7fb; color: #666; border: 2px solid #e8f0fe; padding: 10px; border-radius: 12px; font-size: 0.8rem; cursor: pointer; width: 100%; margin-top: 8px; }
        .ai-result { display: none; margin-top: 18px; background: #f8f5ff; border-radius: 12px; padding: 18px; border-left: 4px solid var(--ai); }
        .ai-loading { display: none; text-align: center; padding: 20px; }
        .spinner { display: inline-block; width: 32px; height: 32px; border: 3px solid #e8f0fe; border-top-color: var(--ai); border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .empty-box { text-align: center; padding: 40px 20px; }
        @media(max-width:768px) { .sidebar { display:none; } .main { margin-left:0; } }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></h4>
        <p>Patient Portal</p>
    </div>
    <div class="sidebar-menu">
        <div class="menu-label">Main</div>
        <a href="/dashboard" class="menu-item active"><i class="fas fa-th-large"></i>Dashboard</a>
        <div class="menu-label">Medical</div>
        <a href="/doctors" class="menu-item"><i class="fas fa-user-md"></i>Find Doctors</a>
        <a href="/my-appointments" class="menu-item"><i class="fas fa-calendar-check"></i>My Appointments</a>
        <div class="menu-label">AI Feature</div>
        <a href="#ai-checker" class="menu-item"><i class="fas fa-robot"></i>AI Symptom Checker</a>
        <div class="menu-label">Account</div>
        <a href="/profile" class="menu-item"><i class="fas fa-user"></i>My Profile</a>
    </div>
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Patient</div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN -->
<div class="main">
    <div class="topbar">
        <div>
            <h5><i class="fas fa-th-large me-2" style="color:var(--primary);"></i>Patient Dashboard</h5>
            <p id="dateDisplay"></p>
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
        </form>
    </div>

    <div class="content">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:12px; font-size:0.83rem;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- NOTIFICATIONS --}}
        @php
            $notifications = $appointments->whereIn('status', ['confirmed', 'cancelled'])->where('patient_notified', false);
        @endphp
        @if($notifications->count() > 0)
        <div class="mb-4">
            @foreach($notifications as $notif)
            <div class="notif-card {{ $notif->status == 'confirmed' ? 'notif-confirmed' : 'notif-cancelled' }}">
                <i class="fas {{ $notif->status == 'confirmed' ? 'fa-check-circle' : 'fa-times-circle' }}"
                    style="font-size:1.4rem; color:{{ $notif->status == 'confirmed' ? '#03c4a1' : '#ff4757' }};"></i>
                <div>
                    <div style="font-weight:700; font-size:0.88rem; color:#0d1b2a;">
                        Appointment {{ $notif->status == 'confirmed' ? '✅ Approved!' : '❌ Rejected!' }}
                    </div>
                    <div style="font-size:0.78rem; color:#555;">
                        Dr. {{ $notif->doctor->name }} ne aapki appointment
                        {{ $notif->status == 'confirmed' ? 'approve' : 'reject' }} kar di —
                        {{ \Carbon\Carbon::parse($notif->appointment_date)->format('d M Y') }}
                        @if($notif->rejection_reason)
                        <br><i class="fas fa-info-circle me-1"></i>{{ $notif->rejection_reason }}
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- WELCOME --}}
        <div class="welcome-banner">
            <div>
                <h4>Hello, {{ auth()->user()->name }}! 👋</h4>
                <p>Book appointments with top doctors easily and use AI to check your symptoms.</p>
            </div>
            <a href="/doctors" class="btn-book-appt"><i class="fas fa-plus me-1"></i>Book Appointment</a>
        </div>

        {{-- STATS --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <div class="stat-num">{{ $appointments->count() }}</div>
                        <div class="stat-label">Total Appointments</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <div class="stat-num">{{ $appointments->where('status','confirmed')->count() }}</div>
                        <div class="stat-label">Confirmed</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="stat-num">{{ $appointments->where('status','pending')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-7">

                {{-- AI SYMPTOM CHECKER --}}
                <div class="ai-card mb-4" id="ai-checker">
                    <div class="ai-header">
                        <div class="ai-icon"><i class="fas fa-robot"></i></div>
                        <div>
                            <div style="font-weight:700; color:#0d1b2a; font-size:0.92rem;">AI Symptom Checker</div>
                            <div style="color:#888; font-size:0.72rem;">Apne symptoms likhein — AI doctor recommend karega</div>
                        </div>
                        <span class="ai-badge">✨ AI Powered</span>
                    </div>
                    <textarea class="ai-textarea" id="symptomInput" rows="3"
                        placeholder="Apne symptoms likhein... (e.g. sir dard, bukhaar, khansi, pet dard, seena dard)"></textarea>
                    <div class="row g-2 mt-2">
                        <div class="col-8">
                            <button onclick="checkSymptoms()" id="aiBtn" class="btn-ai">
                                <i class="fas fa-magic me-2"></i>Check Symptoms
                            </button>
                        </div>
                        <div class="col-4">
                            <button onclick="clearAI()" class="btn-clear">
                                <i class="fas fa-redo me-1"></i>Clear
                            </button>
                        </div>
                    </div>
                    <div class="ai-loading" id="aiLoading">
                        <div class="spinner"></div>
                        <p style="color:#888; font-size:0.8rem; margin-top:10px;">AI analyze kar raha hai...</p>
                    </div>
                    <div class="ai-result" id="aiResult">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
                            <i class="fas fa-robot" style="color:var(--ai);"></i>
                            <span style="font-weight:700; color:#0d1b2a; font-size:0.88rem;">AI Recommendation</span>
                        </div>
                        <div id="aiText" style="font-size:0.82rem; line-height:1.7; color:#333;"></div>
                    </div>
                </div>

                {{-- RECENT APPOINTMENTS --}}
                <div class="section-card">
                    <div class="section-head">
                        <h6><i class="fas fa-list me-2" style="color:var(--primary);"></i>Recent Appointments</h6>
                        <a href="/my-appointments" style="font-size:0.75rem; color:var(--primary); text-decoration:none; font-weight:600;">View All →</a>
                    </div>
                    @forelse($appointments->take(4) as $appt)
                    <div class="appt-card">
                        <div>
                            <div class="appt-doc"><i class="fas fa-user-md me-2" style="color:var(--primary);"></i>Dr. {{ $appt->doctor->name }}</div>
                            <div class="appt-spec">{{ $appt->doctor->specialization }}</div>
                            <div class="appt-meta">
                                <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}
                                &nbsp;<i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                                &nbsp;<i class="fas fa-tag me-1"></i>Rs. {{ $appt->doctor->fee }}
                            </div>
                        </div>
                        <div class="text-end">
                            @if($appt->status=='confirmed')
                                <span class="badge-confirmed">✅ Confirmed</span>
                            @elseif($appt->status=='cancelled')
                                <span class="badge-cancelled">❌ Cancelled</span>
                            @else
                                <span class="badge-pending">⏳ Pending</span>
                            @endif
                            @if($appt->status == 'pending')
                            <br>
                            <form method="POST" action="/appointments/{{ $appt->id }}/cancel" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-cancel-appt" onclick="return confirm('Cancel?')">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="empty-box">
                        <i class="fas fa-calendar-times fa-3x mb-3" style="color:#ddd; display:block;"></i>
                        <p style="color:#aaa; font-size:0.83rem;">No appointments yet!</p>
                        <a href="/doctors" style="background:var(--primary); color:white; padding:8px 20px; border-radius:20px; text-decoration:none; font-size:0.8rem; font-weight:600;">Book Now</a>
                    </div>
                    @endforelse
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-5">

                {{-- QUICK ACTIONS --}}
                <div class="section-card mb-4">
                    <div class="section-head">
                        <h6><i class="fas fa-bolt me-2" style="color:var(--secondary);"></i>Quick Actions</h6>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="/doctors" style="background:#f0f7ff; border-radius:12px; padding:15px; text-align:center; text-decoration:none; display:block;">
                                <i class="fas fa-user-md fa-lg mb-2 d-block" style="color:var(--primary);"></i>
                                <span style="font-size:0.75rem; font-weight:600; color:#0d1b2a;">Find Doctors</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/my-appointments" style="background:#f0faf7; border-radius:12px; padding:15px; text-align:center; text-decoration:none; display:block;">
                                <i class="fas fa-calendar <i class="fas fa-user-md fa-lg mb-2 d-block" style="color:var(--primary);"></i>
                                <span style="font-size:0.75rem; font-weight:600; color:#0d1b2a;">Find Doctors</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/my-appointments" style="background:#f0faf7; border-radius:12px; padding:15px; text-align:center; text-decoration:none; display:block;">
                                <i class="fas fa-calendar-check fa-lg mb-2 d-block" style="color:var(--secondary);"></i>
                                <span style="font-size:0.75rem; font-weight:600; color:#0d1b2a;">My Appointments</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/profile" style="background:#f5f0ff; border-radius:12px; padding:15px; text-align:center; text-decoration:none; display:block;">
                                <i class="fas fa-user fa-lg mb-2 d-block" style="color:var(--ai);"></i>
                                <span style="font-size:0.75rem; font-weight:600; color:#0d1b2a;">My Profile</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#ai-checker" style="background:#fff5f0; border-radius:12px; padding:15px; text-align:center; text-decoration:none; display:block;">
                                <i class="fas fa-robot fa-lg mb-2 d-block" style="color:#ff6b35;"></i>
                                <span style="font-size:0.75rem; font-weight:600; color:#0d1b2a;">AI Checker</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- APPOINTMENT SUMMARY --}}
                <div class="section-card">
                    <div class="section-head">
                        <h6><i class="fas fa-chart-pie me-2" style="color:var(--primary);"></i>Appointment Summary</h6>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; background:#fff3cd; border-radius:10px;">
                            <span style="font-size:0.8rem; color:#856404; font-weight:600;"><i class="fas fa-clock me-2"></i>Pending</span>
                            <span style="font-weight:700; color:#856404;">{{ $appointments->where('status','pending')->count() }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; background:#d1f3e8; border-radius:10px;">
                            <span style="font-size:0.8rem; color:#0a6640; font-weight:600;"><i class="fas fa-check-circle me-2"></i>Confirmed</span>
                            <span style="font-weight:700; color:#0a6640;">{{ $appointments->where('status','confirmed')->count() }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; background:#fde8e8; border-radius:10px;">
                            <span style="font-size:0.8rem; color:#c0392b; font-weight:600;"><i class="fas fa-times-circle me-2"></i>Cancelled</span>
                            <span style="font-weight:700; color:#c0392b;">{{ $appointments->where('status','cancelled')->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function updateTime() {
    const now = new Date();
    const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    document.getElementById('dateDisplay').textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
}
updateTime();
setInterval(updateTime, 1000);

async function checkSymptoms() {
    const symptoms = document.getElementById('symptomInput').value.trim();
    if (!symptoms) { alert('Pehle apne symptoms likhein!'); return; }
    document.getElementById('aiLoading').style.display = 'block';
    document.getElementById('aiResult').style.display = 'none';
    document.getElementById('aiBtn').disabled = true;
    try {
        const response = await fetch('/ai/symptom-check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ symptoms: symptoms })
        });
        const data = await response.json();
        document.getElementById('aiLoading').style.display = 'none';
        document.getElementById('aiResult').style.display = 'block';
        document.getElementById('aiText').innerHTML = data.result;
    } catch(e) {
        document.getElementById('aiLoading').style.display = 'none';
        document.getElementById('aiResult').style.display = 'block';
        document.getElementById('aiText').innerHTML = '<span style="color:red;">Error aaya — dobara try karein!</span>';
    }
    document.getElementById('aiBtn').disabled = false;
}

function clearAI() {
    document.getElementById('symptomInput').value = '';
    document.getElementById('aiResult').style.display = 'none';
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>