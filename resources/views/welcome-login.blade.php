<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare — Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0a6ebd; --secondary: #03c4a1; --dark: #0d1b2a; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, #0a6ebd 0%, #0d1b2a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: rgba(3,196,161,0.1);
            border-radius: 50%;
            top: -150px; right: -150px;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: -100px; left: -100px;
        }
        .main-box {
            text-align: center;
            z-index: 10;
            padding: 20px;
        }
        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: white;
            margin-bottom: 10px;
        }
        .brand span { color: var(--secondary); }
        .brand-sub {
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            margin-bottom: 50px;
        }
        .login-cards {
            display: flex;
            gap: 25px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px 35px;
            width: 220px;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .login-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .card-icon {
            width: 80px; height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }
        .patient-icon { background: linear-gradient(135deg, #0a6ebd, #1a8fe8); color: white; }
        .doctor-icon { background: linear-gradient(135deg, #03c4a1, #02a88a); color: white; }
        .admin-icon { background: linear-gradient(135deg, #0d1b2a, #1a3a5c); color: white; }
        .card-title {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 8px;
        }
        .card-desc {
            color: #888;
            font-size: 0.82rem;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .card-btn {
            display: block;
            padding: 10px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .patient-btn { background: #0a6ebd; color: white; }
        .patient-btn:hover { background: #085a9e; color: white; }
        .doctor-btn { background: #03c4a1; color: white; }
        .doctor-btn:hover { background: #02a88a; color: white; }
        .admin-btn { background: #0d1b2a; color: white; }
        .admin-btn:hover { background: #1a3a5c; color: white; }
        .footer-text {
            color: rgba(255,255,255,0.5);
            font-size: 0.82rem;
            margin-top: 40px;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .main-box { animation: fadeUp 0.8s ease forwards; }
    </style>
</head>
<body>

<div class="main-box">

    {{-- BRAND --}}
    <div class="brand">
        <i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span>
    </div>
    <div class="brand-sub">Online Doctor Appointment System</div>

    {{-- 3 LOGIN CARDS --}}
    <div class="login-cards">

        {{-- PATIENT --}}
        <div class="login-card">
            <div class="card-icon patient-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="card-title">Patient</div>
            <div class="card-desc">Book appointments with top doctors easily</div>
            <a href="/login" class="card-btn patient-btn">
                <i class="fas fa-sign-in-alt me-1"></i>Patient Login
            </a>
        </div>

        {{-- DOCTOR --}}
        <div class="login-card">
            <div class="card-icon doctor-icon">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="card-title">Doctor</div>
            <div class="card-desc">Manage your appointments & patients</div>
            <a href="/doctor/login" class="card-btn doctor-btn">
                <i class="fas fa-sign-in-alt me-1"></i>Doctor Login
            </a>
        </div>

        {{-- ADMIN --}}
        <div class="login-card">
            <div class="card-icon admin-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="card-title">Admin</div>
            <div class="card-desc">Manage complete system & users</div>
            <a href="/admin/login" class="card-btn admin-btn">
                <i class="fas fa-sign-in-alt me-1"></i>Admin Login
            </a>
        </div>

    </div>

    <div class="footer-text">
        New patient? <a href="/register" style="color:var(--secondary); text-decoration:none;">Register here</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>