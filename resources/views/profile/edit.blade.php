<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile — MediCare</title>
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
        .main { padding: 35px; max-width: 700px; margin: 0 auto; }
        .profile-card { background: white; border-radius: 20px; box-shadow: 0 4px 25px rgba(0,0,0,0.08); overflow: hidden; }
        .profile-header { background: linear-gradient(135deg, var(--primary), #0d1b2a); padding: 35px; text-align: center; color: white; }
        .profile-avatar { width: 90px; height: 90px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 15px; }
        .profile-name { font-size: 1.4rem; font-weight: 700; }
        .profile-email { color: rgba(255,255,255,0.8); font-size: 0.9rem; }
        .profile-body { padding: 30px; }
        .form-label { font-weight: 600; color: var(--dark); font-size: 0.9rem; }
        .form-control { border: 2px solid #e8f0fe; border-radius: 10px; padding: 11px 15px; font-size: 0.92rem; }
        .form-control:focus { border-color: var(--primary); box-shadow: none; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 600; transition: all 0.3s; }
        .btn-save:hover { background: #085a9e; color: white; }
        .alert-success-custom { background: #d1f3e8; color: #0a6640; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 0.88rem; }
        .alert-error { background: #fde8e8; color: #c0392b; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 0.88rem; }
        .section-divider { border-top: 2px solid #f0f4ff; margin: 25px 0; }
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
    <div class="profile-card">

        {{-- HEADER --}}
        <div class="profile-header">
            <div class="profile-avatar"><i class="fas fa-user"></i></div>
            <div class="profile-name">{{ auth()->user()->name }}</div>
            <div class="profile-email">{{ auth()->user()->email }}</div>
        </div>

        <div class="profile-body">

            {{-- SUCCESS --}}
            @if(session('status') === 'profile-updated')
                <div class="alert-success-custom">
                    <i class="fas fa-check-circle me-2"></i>Profile updated successfully!
                </div>
            @endif

            {{-- UPDATE NAME/EMAIL --}}
            <h5 style="font-weight:700; color:var(--dark); margin-bottom:20px;">
                <i class="fas fa-user-edit me-2" style="color:var(--primary);"></i>Update Profile
            </h5>

            <form method="POST" action="/profile">
                @csrf
                @method('patch')

                @if($errors->any())
                    <div class="alert-error">
                        @foreach($errors->all() as $error)
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user me-1"></i>Full Name</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ auth()->user()->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope me-1"></i>Email Address</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ auth()->user()->email }}" required>
                </div>

                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
            </form>

            <div class="section-divider"></div>

            {{-- CHANGE PASSWORD --}}
            <h5 style="font-weight:700; color:var(--dark); margin-bottom:20px;">
                <i class="fas fa-lock me-2" style="color:var(--primary);"></i>Change Password
            </h5>

            @if(session('status') === 'password-updated')
                <div class="alert-success-custom">
                    <i class="fas fa-check-circle me-2"></i>Password updated successfully!
                </div>
            @endif

            <form method="POST" action="/password">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn-save">
                    <i class="fas fa-key me-2"></i>Update Password
                </button>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>