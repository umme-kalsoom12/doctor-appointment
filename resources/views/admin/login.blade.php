<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #0a6ebd; --secondary: #03c4a1; --dark: #0d1b2a; }
        body { font-family: sans-serif; background: linear-gradient(135deg, #0d1b2a, #1a3a5c); min-height: 100vh; display: flex; align-items: center; }
        .login-box { background: white; border-radius: 20px; padding: 40px; max-width: 420px; width: 100%; margin: 0 auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .login-icon { width: 75px; height: 75px; background: linear-gradient(135deg, #0d1b2a, var(--primary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; margin: 0 auto 20px; }
        .login-title { text-align: center; font-weight: 700; color: var(--dark); font-size: 1.5rem; }
        .login-sub { text-align: center; color: #888; font-size: 0.9rem; margin-bottom: 30px; }
        .form-label { font-weight: 600; color: var(--dark); font-size: 0.9rem; }
        .form-control { border: 2px solid #e8f0fe; border-radius: 10px; padding: 11px 15px; font-size: 0.92rem; }
        .form-control:focus { border-color: var(--primary); box-shadow: none; }
        .btn-login { background: #0d1b2a; color: white; border: none; padding: 13px; width: 100%; border-radius: 12px; font-size: 1rem; font-weight: 600; margin-top: 10px; }
        .btn-login:hover { background: #1a3a5c; color: white; }
        .alert-error { background: #fde8e8; color: #c0392b; border-radius: 10px; padding: 12px; margin-bottom: 15px; font-size: 0.88rem; }
        .links { text-align: center; margin-top: 20px; font-size: 0.88rem; }
        .links a { color: var(--primary); text-decoration: none; margin: 0 8px; }
    </style>
</head>
<body>
<div class="container">
    <div class="login-box">
        <div class="login-icon"><i class="fas fa-shield-alt"></i></div>
        <div class="login-title">Admin Login</div>
        <div class="login-sub">MediCare Admin Portal</div>

        @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/admin/login">
            @csrf
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope me-1"></i>Email</label>
                <input type="email" name="email" class="form-control"
                    placeholder="admin@email.com" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-lock me-1"></i>Password</label>
                <input type="password" name="password" class="form-control"
                    placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login as Admin
            </button>
        </form>

        <div class="links">
            <a href="/doctor/login"><i class="fas fa-user-md me-1"></i>Doctor Login</a>
            <a href="/login"><i class="fas fa-user me-1"></i>Patient Login</a>
            <a href="/"><i class="fas fa-home me-1"></i>Home</a>
        </div>
    </div>
</div>
</body>
</html>