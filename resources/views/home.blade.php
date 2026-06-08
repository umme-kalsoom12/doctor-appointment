<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare — Doctor Appointment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0a6ebd; --secondary: #03c4a1; --dark: #0d1b2a; --light: #f4f9ff; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--light); }
        .navbar { background: white; box-shadow: 0 2px 20px rgba(0,0,0,0.08); padding: 15px 0; }
        .navbar-brand { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--primary) !important; }
        .navbar-brand span { color: var(--secondary); }
        .nav-link { font-weight: 500; color: #0d1b2a !important; }
        .nav-link:hover { color: var(--primary) !important; }
        .btn-nav { background: var(--primary); color: white !important; border-radius: 25px; padding: 8px 22px !important; }
        .hero { background: linear-gradient(135deg, #0a6ebd 0%, #0d1b2a 100%); min-height: 90vh; display: flex; align-items: center; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; width: 500px; height: 500px; background: rgba(3,196,161,0.12); border-radius: 50%; top: -80px; right: -80px; }
        .hero-title { font-family: 'Playfair Display', serif; font-size: 3.2rem; color: white; line-height: 1.2; }
        .hero-title span { color: #03c4a1; }
        .hero-sub { color: rgba(255,255,255,0.8); font-size: 1.05rem; margin: 20px 0 35px; }
        .btn-primary-custom { background: #03c4a1; color: white; padding: 13px 32px; border-radius: 30px; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; }
        .btn-primary-custom:hover { background: #02a88a; color: white; transform: translateY(-2px); }
        .btn-outline-custom { background: transparent; color: white; border: 2px solid rgba(255,255,255,0.5); padding: 13px 32px; border-radius: 30px; font-weight: 600; text-decoration: none; display: inline-block; margin-left: 12px; transition: all 0.3s; }
        .btn-outline-custom:hover { background: white; color: var(--primary); }
        .stats { background: white; padding: 40px 0; box-shadow: 0 5px 25px rgba(0,0,0,0.06); }
        .stat-num { font-family: 'Playfair Display', serif; font-size: 2.4rem; color: var(--primary); font-weight: 700; }
        .stat-label { color: #666; font-size: 0.88rem; }
        .section { padding: 85px 0; }
        .sec-title { font-family: 'Playfair Display', serif; font-size: 2.3rem; color: var(--dark); }
        .sec-sub { color: #777; margin-top: 8px; }
        .feature-card { background: white; border-radius: 16px; padding: 38px 28px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.3s; height: 100%; }
        .feature-card:hover { transform: translateY(-7px); box-shadow: 0 14px 35px rgba(10,110,189,0.14); }
        .f-icon { width: 72px; height: 72px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; font-size: 1.7rem; color: white; }
        .feature-card h5 { font-weight: 600; margin-bottom: 10px; }
        .feature-card p { color: #777; font-size: 0.9rem; }
        .doctor-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.07); transition: all 0.3s; }
        .doctor-card:hover { transform: translateY(-6px); box-shadow: 0 14px 35px rgba(10,110,189,0.14); }
        .doc-img { height: 200px; background: linear-gradient(135deg, #e8f4ff, #d0eeea); display: flex; align-items: center; justify-content: center; font-size: 5rem; color: var(--primary); }
        .doc-body { padding: 18px; }
        .doc-name { font-weight: 700; font-size: 1.05rem; color: var(--dark); }
        .doc-spec { color: var(--secondary); font-size: 0.83rem; font-weight: 500; margin: 4px 0 10px; }
        .doc-fee { font-weight: 700; color: var(--primary); }
        .doc-exp { font-size: 0.82rem; color: #777; }
        .btn-book { background: var(--primary); color: white; border: none; padding: 10px 0; width: 100%; border-radius: 8px; font-weight: 600; margin-top: 12px; text-decoration: none; display: block; text-align: center; transition: background 0.3s; }
        .btn-book:hover { background: #085a9e; color: white; }
        .step-num { width: 58px; height: 58px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 700; margin: 0 auto 16px; }
        .step-card { text-align: center; padding: 20px; }
        .cta { background: linear-gradient(135deg, var(--primary), #0d1b2a); padding: 75px 0; text-align: center; }
        .cta h2 { font-family: 'Playfair Display', serif; color: white; font-size: 2.4rem; }
        .cta p { color: rgba(255,255,255,0.8); margin: 14px 0 28px; }
        footer { background: #0d1b2a; color: rgba(255,255,255,0.65); padding: 50px 0 22px; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: white; }
        .footer-brand span { color: #03c4a1; }
        footer h6 { color: white; font-weight: 600; margin-bottom: 14px; }
        footer a { color: rgba(255,255,255,0.55); text-decoration: none; display: block; margin-bottom: 7px; font-size: 0.88rem; }
        footer a:hover { color: #03c4a1; }
        .footer-line { border-top: 1px solid rgba(255,255,255,0.1); margin-top: 38px; padding-top: 18px; text-align: center; font-size: 0.83rem; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
        .hero-content { animation: fadeUp 0.8s ease forwards; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#doctors">Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#how">How it Works</a></li>
            </ul>
            <div class="d-flex gap-2 align-items-center">
                @auth
                    <a href="/dashboard" class="nav-link btn-nav">Dashboard</a>
                @else
                    <a href="/login" class="nav-link">Login</a>
                    <a href="/register" class="nav-link btn-nav">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">Your Health,<br><span>Our Priority</span></h1>
                <p class="hero-sub">Book appointments with top doctors instantly. Fast, secure, and hassle-free online consultation booking system.</p>
                <a href="/register" class="btn-primary-custom"><i class="fas fa-calendar-check me-2"></i>Book Appointment</a>
                <a href="#doctors" class="btn-outline-custom"><i class="fas fa-user-md me-2"></i>Our Doctors</a>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <i class="fas fa-hospital-user" style="font-size:16rem; color:rgba(255,255,255,0.07);"></i>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="stats">
    <div class="container">
        <div class="row text-center">
            <div class="col-6 col-md-3"><div class="stat-num">150+</div><div class="stat-label">Expert Doctors</div></div>
            <div class="col-6 col-md-3"><div class="stat-num">5K+</div><div class="stat-label">Happy Patients</div></div>
            <div class="col-6 col-md-3"><div class="stat-num">20+</div><div class="stat-label">Specializations</div></div>
            <div class="col-6 col-md-3"><div class="stat-num">98%</div><div class="stat-label">Success Rate</div></div>
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section class="section" id="features" style="background:#f4f9ff;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="sec-title">Why Choose <span style="color:var(--primary)">MediCare?</span></h2>
            <p class="sec-sub">Everything you need for seamless healthcare</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4"><div class="feature-card"><div class="f-icon"><i class="fas fa-clock"></i></div><h5>24/7 Booking</h5><p>Book appointments anytime. No waiting in queues or long phone calls.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="f-icon"><i class="fas fa-user-md"></i></div><h5>Expert Doctors</h5><p>Access verified specialists across all medical fields with proven records.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="f-icon"><i class="fas fa-shield-alt"></i></div><h5>Secure & Private</h5><p>Your medical data is fully encrypted and protected with top-grade security.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="f-icon"><i class="fas fa-bell"></i></div><h5>Reminders</h5><p>Get automatic reminders so you never miss an important appointment.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="f-icon"><i class="fas fa-file-medical"></i></div><h5>Digital Records</h5><p>All your appointments and medical history stored safely in one place.</p></div></div>
            <div class="col-md-4"><div class="feature-card"><div class="f-icon"><i class="fas fa-mobile-alt"></i></div><h5>Mobile Friendly</h5><p>Fully responsive — works perfectly on any device, anywhere.</p></div></div>
        </div>
    </div>
</section>

{{-- DOCTORS --}}
<section class="section" id="doctors" style="background:white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="sec-title">Meet Our <span style="color:var(--primary)">Doctors</span></h2>
            <p class="sec-sub">Experienced specialists ready to help you</p>
        </div>
        <div class="row g-4">
            @forelse($doctors as $doctor)
            <div class="col-md-4">
                <div class="doctor-card">
                    <div class="doc-img"><i class="fas fa-user-md"></i></div>
                    <div class="doc-body">
                        <div class="doc-name">Dr. {{ $doctor->name }}</div>
                        <div class="doc-spec">{{ $doctor->specialization }}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="doc-exp"><i class="fas fa-briefcase me-1"></i>{{ $doctor->experience }} yrs exp</span>
                            <span class="doc-fee">Rs. {{ $doctor->fee }}</span>
                        </div>
                        @auth
                            <a href="/book-appointment/{{ $doctor->id }}" class="btn-book"><i class="fas fa-calendar-check me-2"></i>Book Now</a>
                        @else
                            <a href="/login" class="btn-book"><i class="fas fa-lock me-2"></i>Login to Book</a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-user-md fa-4x mb-3" style="color:#ccc;"></i>
                <h5 style="color:#999;">Doctors will be added soon!</h5>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="section" id="how" style="background:#f4f9ff;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="sec-title">How It <span style="color:var(--primary)">Works</span></h2>
            <p class="sec-sub">Book your appointment in 3 simple steps</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4"><div class="step-card"><div class="step-num">1</div><h5>Create Account</h5><p>Register free and create your patient profile in minutes.</p></div></div>
            <div class="col-md-4"><div class="step-card"><div class="step-num">2</div><h5>Choose Doctor</h5><p>Browse specialists and select the right doctor for your needs.</p></div></div>
            <div class="col-md-4"><div class="step-card"><div class="step-num">3</div><h5>Book & Confirm</h5><p>Pick date and time slot — confirm your appointment instantly.</p></div></div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta">
    <div class="container">
        <h2>Ready to Book Your Appointment?</h2>
        <p>Join thousands of patients who trust MediCare for their healthcare.</p>
        <a href="/register" class="btn-primary-custom"><i class="fas fa-calendar-check me-2"></i>Get Started Free</a>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="footer-brand"><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span></div>
                <p class="mt-3" style="font-size:0.88rem;">Your trusted online doctor appointment platform. Quality healthcare made accessible for everyone.</p>
            </div>
            <div class="col-md-2">
                <h6>Quick Links</h6>
                <a href="/">Home</a>
                <a href="/doctors">Doctors</a>
                <a href="/register">Register</a>
                <a href="/login">Login</a>
            </div>
            <div class="col-md-3">
                <h6>Specializations</h6>
                <a href="#">Cardiologist</a>
                <a href="#">Dermatologist</a>
                <a href="#">Neurologist</a>
                <a href="#">Pediatrician</a>
            </div>
            <div class="col-md-3">
                <h6>Contact</h6>
                <a href="#"><i class="fas fa-envelope me-2"></i>info@medicare.com</a>
                <a href="#"><i class="fas fa-phone me-2"></i>+92 300 1234567</a>
                <a href="#"><i class="fas fa-map-marker-alt me-2"></i>Lahore, Pakistan</a>
            </div>
        </div>
        <div class="footer-line">© 2024 MediCare. All rights reserved. Built with ❤️ using Laravel</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>