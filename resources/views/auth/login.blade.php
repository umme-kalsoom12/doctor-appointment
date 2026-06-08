<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Poppins', sans-serif; min-height: 100vh; background: linear-gradient(135deg, #0a6ebd 0%, #0d1b2a 100%); display: flex; align-items: center; justify-content: center; }
        .login-wrapper { display: flex; background: white; border-radius: 24px; overflow: hidden; width: 100%; max-width: 850px; box-shadow: 0 25px 80px rgba(0,0,0,0.3); min-height: 500px; }
        .login-left { background: linear-gradient(135deg, #0a6ebd, #03c4a1); padding: 50px 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; width: 38%; }
        .login-left h2 { color: white; font-weight: 700; font-size: 1.8rem; margin-bottom: 10px; }
        .login-left p { color: rgba(255,255,255,0.85); font-size: 0.88rem; margin-bottom: 30px; }
        .btn-register-link { border: 2px solid white; color: white; background: transparent; padding: 10px 28px; border-radius: 25px; font-weight: 600; font-size: 0.88rem; text-decoration: none; transition: all 0.3s; display: inline-block; }
        .btn-register-link:hover { background: white; color: #0a6ebd; }
        .login-right { padding: 45px 40px; flex: 1; }
        .brand { text-align: center; margin-bottom: 25px; }
        .brand h3 { font-weight: 700; color: #0a6ebd; font-size: 1.6rem; }
        .brand span { color: #03c4a1; }
        .brand p { color: #888; font-size: 0.82rem; margin-top: 3px; }
        .role-tabs { display: flex; gap: 8px; margin-bottom: 22px; }
        .role-tab { flex: 1; padding: 10px 5px; border: 2px solid #e8f0fe; border-radius: 12px; text-align: center; cursor: pointer; font-size: 0.78rem; font-weight: 600; color: #888; transition: all 0.2s; background: white; }
        .role-tab.active { border-color: #0a6ebd; background: #0a6ebd; color: white; }
        .role-tab i { display: block; font-size: 1.2rem; margin-bottom: 3px; }
        .role-tab.doctor-active { border-color: #03c4a1; background: #03c4a1; }
        .role-tab.admin-active { border-color: #0d1b2a; background: #0d1b2a; }
        .form-label { font-weight: 600; color: #333; font-size: 0.85rem; }
        .form-control { border: 2px solid #e8f0fe; border-radius: 10px; padding: 10px 14px; font-size: 0.9rem; transition: border 0.3s; }
        .form-control:focus { border-color: #0a6ebd; box-shadow: none; }
        .btn-login { color: white; border: none; padding: 12px; width: 100%; border-radius: 12px; font-size: 0.95rem; font-weight: 600; margin-top: 8px; transition: all 0.3s; }
        .btn-patient { background: #0a6ebd; }
        .btn-patient:hover { background: #085a9e; }
        .btn-doctor { background: #03c4a1; }
        .btn-doctor:hover { background: #02a88a; }
        .btn-admin { background: #0d1b2a; }
        .btn-admin:hover { background: #1a3a5c; }
        .alert-error { background: #fde8e8; color: #c0392b; border-radius: 10px; padding: 10px 14px; margin-bottom: 15px; font-size: 0.82rem; }
        .hint-box { background: #f0f9f6; border-radius: 10px; padding: 12px; margin-top: 15px; font-size: 0.78rem; color: #555; border-left: 3px solid #03c4a1; }
        .hint-box strong { color: #0a6ebd; }
        @media(max-width: 600px) { .login-left { display: none; } .login-wrapper { max-width: 420px; } }
    </style>
</head>
<body>
<div class="container px-3">
    <div class="login-wrapper">

        {{-- LEFT SIDE --}}
        <div class="login-left">
            <div>
                <i class="fas fa-heartbeat fa-3x mb-3" style="color:rgba(255,255,255,0.9);"></i>
                <h2>Welcome Back!</h2>
                <p>Don't have an account? Register as Patient or Doctor</p>
                <a href="/register" class="btn-register-link">Create Account</a>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="login-right">
            <div class="brand">
                <h3><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></h3>
                <p>Online Doctor Appointment System</p>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $errors->first() }}
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
                <div class="role-tab" id="tab-admin" onclick="switchRole('admin')">
                    <i class="fas fa-shield-alt"></i>Admin
                </div>
            </div>

            {{-- FORM --}}
            <form method="POST" action="/login" id="loginForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope me-1"></i>Email Address</label>
                    <input type="email" name="email" class="form-control"
                        placeholder="Enter your email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock me-1"></i>Password</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-login btn-patient" id="loginBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    <span id="btnText">Sign In as Patient</span>
                </button>
            </form>

            {{-- HINT --}}
            <div class="hint-box" id="hintBox">
                <strong><i class="fas fa-info-circle me-1"></i>Patient:</strong>
                Register karke account banao ya existing account se login karo.
            </div>
        </div>
    </div>
</div>

<script>
function switchRole(role) {
    document.querySelectorAll('.role-tab').forEach(t => {
        t.classList.remove('active', 'doctor-active', 'admin-active');
    });

    const tab = document.getElementById('tab-' + role);
    if (role === 'doctor') tab.classList.add('active', 'doctor-active');
    else if (role === 'admin') tab.classList.add('active', 'admin-active');
    else tab.classList.add('active');

    const btn = document.getElementById('loginBtn');
    btn.className = 'btn-login btn-' + role;

    const texts = { patient: 'Sign In as Patient', doctor: 'Sign In as Doctor', admin: 'Sign In as Admin' };
    document.getElementById('btnText').textContent = texts[role];

    const hints = {
        patient: '<strong><i class="fas fa-user me-1"></i>Patient:</strong> Register karke account banao ya existing account se login karo.',
        doctor:  '<strong><i class="fas fa-user-md me-1"></i>Doctor:</strong> Admin se account banwao ya register se doctor account banao. <br>Email: ahmed@medicare.com | Password: doctor123',
        admin:   '<strong><i class="fas fa-shield-alt me-1"></i>Admin:</strong> Admin account se login karo.<br>Email: admin@medicare.com | Password: admin123'
    };
    document.getElementById('hintBox').innerHTML = hints[role];
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>