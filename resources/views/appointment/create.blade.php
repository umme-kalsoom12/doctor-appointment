<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment — MediCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        :root { --primary: #0a6ebd; --secondary: #03c4a1; --dark: #0d1b2a; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #0a6ebd, #0d1b2a); min-height: 100vh; display: flex; align-items: center; padding: 30px 0; }
        .card-box { background: white; border-radius: 20px; max-width: 620px; margin: 0 auto; width: 100%; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .card-head { background: linear-gradient(135deg, var(--primary), #0d1b2a); padding: 28px 30px; color: white; }
        .card-head h4 { font-weight: 700; font-size: 1.3rem; }
        .card-head p { color: rgba(255,255,255,0.75); font-size: 0.82rem; margin: 4px 0 0; }
        .card-body { padding: 30px; }
        .doc-info { background: #f0f9f6; border-radius: 14px; padding: 18px; margin-bottom: 25px; display: flex; align-items: center; gap: 15px; border-left: 4px solid var(--secondary); }
        .doc-avatar { width: 55px; height: 55px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: white; flex-shrink: 0; }
        .doc-name { font-weight: 700; color: var(--dark); font-size: 1rem; }
        .doc-spec { color: var(--secondary); font-size: 0.82rem; }
        .doc-fee { color: var(--primary); font-weight: 700; font-size: 0.85rem; margin-top: 3px; }
        .schedule-info { background: #f0f7ff; border-radius: 12px; padding: 15px; margin-bottom: 20px; }
        .schedule-info h6 { font-weight: 700; color: var(--dark); font-size: 0.85rem; margin-bottom: 10px; }
        .schedule-tag { background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; margin: 3px; display: inline-block; }
        .no-schedule { background: #fff3cd; color: #856404; padding: 10px; border-radius: 10px; font-size: 0.82rem; }
        .form-label { font-weight: 600; color: var(--dark); font-size: 0.85rem; margin-bottom: 6px; }
        .form-control { border: 2px solid #e8f0fe; border-radius: 10px; padding: 10px 14px; font-size: 0.88rem; }
        .form-control:focus { border-color: var(--primary); box-shadow: none; }
        .time-slots { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-top: 8px; }
        .time-slot { padding: 9px 5px; border: 2px solid #e8f0fe; border-radius: 10px; text-align: center; cursor: pointer; font-size: 0.78rem; font-weight: 500; transition: all 0.2s; }
        .time-slot:hover { border-color: var(--primary); background: #f0f7ff; }
        .time-slot.selected { border-color: var(--primary); background: var(--primary); color: white; }
        .btn-submit { background: var(--primary); color: white; border: none; padding: 13px; width: 100%; border-radius: 12px; font-size: 0.95rem; font-weight: 600; margin-top: 10px; }
        .btn-submit:hover { background: #085a9e; color: white; }
        .btn-back { color: var(--primary); text-decoration: none; font-size: 0.82rem; }
        .alert-error { background: #fde8e8; color: #c0392b; border-radius: 10px; padding: 12px; margin-bottom: 15px; font-size: 0.82rem; }
    </style>
</head>
<body>
<div class="container px-3">
    <div class="card-box">
        <div class="card-head">
            <h4><i class="fas fa-calendar-check me-2"></i>Book Appointment</h4>
            <p>Send appointment request to doctor</p>
        </div>
        <div class="card-body">

            <!-- DOCTOR INFO -->
            <div class="doc-info">
                <div class="doc-avatar"><i class="fas fa-user-md"></i></div>
                <div>
                    <div class="doc-name">Dr. {{ $doctor->name }}</div>
                    <div class="doc-spec">{{ $doctor->specialization }}</div>
                    <div class="doc-fee"><i class="fas fa-tag me-1"></i>Fee: Rs. {{ $doctor->fee }} &nbsp;|&nbsp; <i class="fas fa-briefcase me-1"></i>{{ $doctor->experience }} yrs exp</div>
                </div>
            </div>

            <!-- SCHEDULE INFO -->
            @if($schedules->count() > 0)
            <div class="schedule-info">
                <h6><i class="fas fa-calendar-check me-1" style="color:var(--secondary);"></i>Doctor Available Days:</h6>
                @foreach($schedules as $s)
                <span class="schedule-tag">
                    {{ $s->day }}: {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}
                </span>
                @endforeach
            </div>
            @else
            <div class="no-schedule mb-4">
                <i class="fas fa-info-circle me-1"></i>Doctor ne schedule set nahi kiya — phir bhi request bhej sakte ho.
            </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/book-appointment">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-calendar me-1"></i>Appointment Date</label>
                    <input type="date" name="appointment_date" class="form-control"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        value="{{ old('appointment_date') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-clock me-1"></i>Select Time Slot</label>
                    <div class="time-slots">
                        @foreach([
'14:00','14:30',
'15:00','15:30',
'16:00','16:30',
'17:00','17:30',
'18:00','18:30',
'19:00','19:30',
'20:00','20:30',
'21:00','21:30',
'22:00','22:30',
'23:00','23:30'
] as $time)
                        <div class="time-slot {{ old('appointment_time') == $time ? 'selected' : '' }}"
                            onclick="selectTime('{{ $time }}', this)">
                            {{ \Carbon\Carbon::createFromFormat('H:i', $time)->format('h:i A') }}
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="appointment_time" id="selectedTime" value="{{ old('appointment_time') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-sticky-note me-1"></i>Symptoms / Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3"
                        placeholder="Apne symptoms ya visit ka reason likhein...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane me-2"></i>Send Appointment Request
                </button>
                <div class="text-center mt-3">
                    <a href="/doctors" class="btn-back"><i class="fas fa-arrow-left me-1"></i>Back to Doctors</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function selectTime(time, el) {
    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selectedTime').value = time;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>