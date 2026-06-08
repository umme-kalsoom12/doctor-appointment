<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Poppins', sans-serif; min-height: 100vh; background: linear-gradient(135deg, #0a6ebd 0%, #0d1b2a 100%); display: flex; align-items: center; justify-content: center; padding: 30px 0; }
        .register-wrapper { display: flex; background: white; border-radius: 24px; overflow: hidden; width: 100%; max-width: 850px; box-shadow: 0 25px 80px rgba(0,0,0,0.3); }
        .register-left { background: linear-gradient(135deg, #0d1b2a, #0a6ebd); padding: 50px 35px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; width: 38%; }
        .register-left h2 { color: white; font-weight: 700; font-size: 1.7rem; margin-bottom: 10px; }
        .register-left p { color: rgba(255,255,255,0.8); font-size: 0.85rem; margin-bottom: 30px; }
        .btn-login-link { border: 2px solid white; color: white; background: transparent; padding: 10px 28px; border-radius: 25px; font-weight: 600; font-size: 0.88rem; text-decoration: none; transition: all 0.3s; display: inline-block; }
        .btn-login-link:hover { background: white; color: #0a6ebd; }
        .register-right { padding: 40px; flex: 1; overflow-y: auto; }
        .brand { text-align: center; margin-bottom: 20px; }
        .brand h3 { font-weight: 700; color: #0a6ebd; font-size: 1.5rem; }
        .brand span { color: #03c4a1; }
        .role-tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .role-tab { flex: 1; padding: 12px; border: 2px solid #e8f0fe; border-radius: 12px; text-align: center; cursor: pointer; font-size: 0.82rem; font-weight: 600; color: #888; transition: all 0.2s; }
        .role-tab i { display: block; font-size: 1.3rem; margin-bottom: 4px; }
        .role-tab.active { border-color: #0a6ebd; background: #0a6ebd; color: white; }
        .role-tab.doctor-active { border-color: #03c4a1; background: #03c4a1; color: white; }
        .form-label { font-weight: 600; color: #333; font-size: 0.83rem; }
        .form-control { border: 2px solid #e8f0fe; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; }
        .form-control:focus { border-color: #0a6ebd; box-shadow: none; }
        .btn-register { color: white; border: none; padding: 12px; width: 100%; border-radius: 12px; font-size: 0.95rem; font-weight: 600; margin-top: 8px; }
        .btn-patient { background: #0a6ebd; }
        .btn-doctor { background: #03c4a1; }
        .alert-error { background: #fde8e8; color: #c0392b; border-radius: 10px; padding: 10px 14px; margin-bottom: 15px; font-size: 0.82rem; }
        .extra-fields { display: none; }
        @media(max-width: 600px) { .register-left { display: none; } }
    </style>
</head>
<body>
<div class="container px-3">
    <div class="register-wrapper">

        {{-- LEFT --}}
        <div class="register-left">
            <div>
                <i class="fas fa-heartbeat fa-3x mb-3" style="color:rgba(255,255,255,0.9);"></i>
                <h2>Join MediCare!</h2>
                <p>Already have an account? Sign in to continue.</p>
                <a href="/login" class="btn-login-link">Sign In</a>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="register-right">
            <div class="brand">
                <h3><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></h3>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $error }}<br>
                    @endforeach
                </div>
            @endif

            {{-- ROLE TABS --}}
            <div class="role-tabs">
                <div class="role-tab active" id="tab-patient" onclick="switchRole('patient')">
                    <i class="fas fa-user"></i>Patient
                </div>
                <div class="role-tab" id="tab-doctor" onclick="switchRole('doctor')">
                    <i class="fas fa-user-md"></i>Doctor
                </div>
            </div>

            <form method="POST" action="/register">
                @csrf
                <input type="hidden" name="role" id="roleInput" value="patient">

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Your full name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="your@email.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                    </div>

                    {{-- DOCTOR EXTRA FIELDS --}}
                    <div class="col-12 extra-fields" id="doctorFields">
                        <hr>
                        <p style="font-size:0.82rem; color:#888; margin-bottom:10px;"><i class="fas fa-info-circle me-1"></i>Doctor additional info:</p>
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label">Specialization</label>
                                <input type="text" name="specialization" class="form-control" placeholder="e.g. Cardiologist">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="0300-0000000">
                            </div>
                            <div class="col-3">
                                <label class="form-label">Experience</label>
                                <input type="number" name="experience" class="form-control" placeholder="Yrs">
                            </div>
                            <div class="col-3">
                                <label class="form-label">Fee (Rs.)</label>
                                <input type="number" name="fee" class="form-control" placeholder="500">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn-register btn-patient" id="registerBtn">
                            <i class="fas fa-user-plus me-2"></i>
                            <span id="btnText">Create Patient Account</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function switchRole(role) {
    document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active', 'doctor-active'));
    const tab = document.getElementById('tab-' + role);
    if (role === 'doctor') tab.classList.add('active', 'doctor-active');
    else tab.classList.add('active');

    document.getElementById('roleInput').value = role;

    const btn = document.getElementById('registerBtn');
    btn.className = 'btn-register btn-' + role;

    const texts = { patient: 'Create Patient Account', doctor: 'Create Doctor Account' };
    document.getElementById('btnText').textContent = texts[role];

    const doctorFields = document.getElementById('doctorFields');
    doctorFields.style.display = role === 'doctor' ? 'block' : 'none';
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>