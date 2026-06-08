<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors — MediCare Admin</title>
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
        .nav-link-custom:hover, .nav-link-custom.active { background: var(--primary); color: white; }
        .main { padding: 35px; }
        .add-form { background: white; border-radius: 14px; padding: 28px; box-shadow: 0 4px 18px rgba(0,0,0,0.06); margin-bottom: 30px; }
        .form-label { font-weight: 600; font-size: 0.88rem; color: var(--dark); }
        .form-control { border: 2px solid #e8f0fe; border-radius: 10px; padding: 10px 14px; font-size: 0.9rem; }
        .form-control:focus { border-color: var(--primary); box-shadow: none; }
        .btn-add { background: var(--primary); color: white; border: none; padding: 11px 28px; border-radius: 10px; font-weight: 600; }
        .btn-add:hover { background: #085a9e; color: white; }
        .table-box { background: white; border-radius: 14px; box-shadow: 0 4px 18px rgba(0,0,0,0.06); overflow: hidden; }
        .table-box th { background: var(--dark); color: white; padding: 14px 16px; font-size: 0.88rem; font-weight: 500; }
        .table-box td { padding: 12px 16px; font-size: 0.88rem; vertical-align: middle; }
        .table-box tr:hover { background: #f8fbff; }
        .btn-delete { background: #ff4757; color: white; border: none; padding: 6px 14px; border-radius: 8px; font-size: 0.82rem; cursor: pointer; }
        .btn-delete:hover { background: #e03347; }
        .alert-error { background: #fde8e8; color: #c0392b; border-radius: 10px; padding: 12px 16px; margin-bottom: 15px; font-size: 0.88rem; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand"><i class="fas fa-heartbeat me-2"></i>Medi<span>Care</span>
        <small style="font-size:0.7rem; background:var(--primary); color:white; padding:2px 8px; border-radius:10px; margin-left:8px;">ADMIN</small>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="/admin/dashboard" class="nav-link-custom"><i class="fas fa-th-large me-1"></i>Dashboard</a>
        <a href="/admin/doctors" class="nav-link-custom active"><i class="fas fa-user-md me-1"></i>Doctors</a>
        <a href="/admin/appointments" class="nav-link-custom"><i class="fas fa-calendar me-1"></i>Appointments</a>
        <form method="POST" action="/admin/logout">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
        </form>
    </div>
</div>

<div class="main">
    <h4 style="font-weight:700; color:var(--dark); margin-bottom:25px;">
        <i class="fas fa-user-md me-2" style="color:var(--primary);"></i>Manage Doctors
    </h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <i class="fas fa-exclamation-circle me-1"></i>{{ $error }}<br>
            @endforeach
        </div>
    @endif

    {{-- ADD DOCTOR FORM --}}
    <div class="add-form">
        <h5 style="font-weight:700; margin-bottom:20px;">
            <i class="fas fa-plus-circle me-2" style="color:var(--secondary);"></i>Add New Doctor
        </h5>
        <form method="POST" action="/admin/doctors">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Doctor Name" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Specialization</label>
                    <input type="text" name="specialization" class="form-control" placeholder="e.g. Cardiologist" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="doctor@email.com" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="0300-0000000" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Experience (years)</label>
                    <input type="number" name="experience" class="form-control" placeholder="5" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fee (Rs.)</label>
                    <input type="number" name="fee" class="form-control" placeholder="1500" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn-add">
                        <i class="fas fa-plus me-2"></i>Add Doctor
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- DOCTORS TABLE --}}
    <div class="table-box">
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Experience</th>
                    <th>Fee</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $i => $doctor)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><i class="fas fa-user-md me-1" style="color:var(--primary);"></i>Dr. {{ $doctor->name }}</td>
                    <td style="color:var(--secondary); font-weight:500;">{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->phone }}</td>
                    <td>{{ $doctor->experience }} yrs</td>
                    <td>Rs. {{ $doctor->fee }}</td>
                    <td>
                        <form method="POST" action="/admin/doctors/{{ $doctor->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete"
                                onclick="return confirm('Delete Dr. {{ $doctor->name }}?')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">No doctors added yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>