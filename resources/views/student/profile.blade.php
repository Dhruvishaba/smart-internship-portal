@extends('layouts.app')

@section('content')

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --bg:         #f0f4fa;
    --surface:    #ffffff;
    --surface2:   #f7f9fc;
    --border:     #e2e8f4;
    --accent:     #3b7ef8;
    --accent2:    #6c4ef7;
    --accent-lt:  #eef3ff;
    --success:    #16a34a;
    --danger:     #dc2626;
    --text:       #111827;
    --muted:      #6b7280;
    --label:      #374151;

    /* UPDATED FONTS */
    --font-head: 'Poppins', sans-serif;
    --font-body: 'Inter', sans-serif;

    --radius:     14px;
    --radius-sm:  8px;
    --shadow:     0 4px 24px rgba(59,126,248,0.08), 0 1px 4px rgba(0,0,0,0.06);
    --shadow-hover: 0 8px 32px rgba(59,126,248,0.14), 0 2px 8px rgba(0,0,0,0.07);
}

body {
    background: var(--bg);
    font-family: var(--font-body);
    color: var(--text);
    min-height: 100vh;
}

body::before {
    content: '';
    position: fixed;
    inset: 0;
    background:
        radial-gradient(ellipse 70% 40% at 15% 0%, rgba(59,126,248,0.06) 0%, transparent 60%),
        radial-gradient(ellipse 60% 40% at 90% 100%, rgba(108,78,247,0.05) 0%, transparent 60%);
    pointer-events: none;
    z-index: 0;
}

.page-wrap {
    max-width: 980px;
    margin: auto;
    position: relative;
    z-index: 1;
}

/* ── Page Header ── */
.page-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 32px;
}

.page-header-icon {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 4px 18px rgba(59,126,248,0.3);
}

.page-header h2 {
    font-family: var(--font-head);
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: var(--text);
}

.page-header p {
    font-size: 13.5px;
    color: var(--muted);
    margin-top: 3px;
}

/* ── Card ── */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 32px 36px;
    margin-bottom: 22px;
    box-shadow: var(--shadow);
    transition: box-shadow 0.25s, border-color 0.25s;
}

.card:hover {
    box-shadow: var(--shadow-hover);
    border-color: rgba(59,126,248,0.2);
}

/* ── Section Title ── */
.section-title {
    font-family: var(--font-head);
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--accent);
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 26px;
    padding-bottom: 14px;
    border-bottom: 1.5px solid var(--border);
}

.section-title i { font-size: 13px; }

/* ── Success Alert ── */
.success-box {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
    padding: 13px 18px;
    border-radius: var(--radius-sm);
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 500;
}

/* ── Labels ── */
label, .field-label {
    font-family: var(--font-body);
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.4px;
    color: var(--label);
    display: flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
    margin-bottom: 7px;
}

label i, .field-label i { color: var(--accent); font-size: 11px; }

.field-group { display: flex; flex-direction: column; }

/* ── Inputs ── */
.form-control {
    background: var(--surface2);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 11px 14px;
    color: var(--text);
    font-family: var(--font-body);
    font-size: 14px;
    font-weight: 400;
    width: 100%;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}

.form-control::placeholder { color: #c0c8d8; }

.form-control:focus {
    outline: none;
    border-color: var(--accent);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(59,126,248,0.1);
}

select.form-control {
    cursor: pointer;
    appearance: none;
    background-repeat: no-repeat;
    background-position: right 13px center;
    padding-right: 38px;
}

textarea.form-control { resize: vertical; min-height: 100px; line-height: 1.65; }

/* ── Grids ── */
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
.grid-4 { display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 16px; }

@media (max-width: 740px) {
    .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
    .card { padding: 22px 18px; }
    .page-header h2 { font-size: 22px; }
}

/* ── Photo Section ── */
.photo-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
}

.photo-wrapper {
    position: relative;
    width: 128px;
    height: 128px;
}

.profile-photo {
    width: 128px;
    height: 128px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ffffff;
    display: block;
    box-shadow: 0 0 0 3px var(--accent), 0 6px 24px rgba(59,126,248,0.18);
    transition: box-shadow 0.2s;
}

.photo-wrapper:hover .profile-photo {
    box-shadow: 0 0 0 3px var(--accent2), 0 8px 30px rgba(108,78,247,0.22);
}

.photo-edit-btn {
    position: absolute;
    bottom: 4px;
    right: 4px;
    width: 34px;
    height: 34px;
    background: var(--accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 13px;
    cursor: pointer;
    border: 2.5px solid #ffffff;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 3px 10px rgba(59,126,248,0.35);
}

.photo-edit-btn:hover { background: var(--accent2); transform: scale(1.1); }

.photo-upload-input { display: none; }

.photo-hint {
    font-size: 12px;
    color: var(--muted);
    text-align: center;
}

/* ── Education Sub-header ── */
.edu-sub {
    font-family: var(--font-head);
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 14px;
    background: var(--accent-lt);
    border-radius: var(--radius-sm);
    border-left: 3px solid var(--accent);
}

.edu-sub i { color: var(--accent); font-size: 14px; }

/* ── Certifications ── */
.cert-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    animation: slideIn 0.2s ease;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(-5px); }
    to   { opacity: 1; transform: translateY(0); }
}

.cert-number {
    font-family: var(--font-head);
    font-size: 13px;
    font-weight: 700;
    color: var(--accent);
    width: 24px;
    flex-shrink: 0;
    text-align: right;
}

/* ── Radio Group ── */
.radio-group { display: flex; gap: 12px; }

.radio-option {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: var(--surface2);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    font-size: 14px;
    font-weight: 500;
    color: var(--muted);
    user-select: none;
}

.radio-option input[type="radio"] { display: none; }

.radio-dot {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: border-color 0.2s, background 0.2s;
}

.radio-option:has(input:checked) .radio-dot {
    border-color: var(--accent);
    background: var(--accent);
}

.radio-option:has(input:checked) .radio-dot::after {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: white;
    display: block;
}

.radio-option:has(input:checked) {
    border-color: var(--accent);
    background: var(--accent-lt);
    color: var(--text);
    box-shadow: 0 0 0 3px rgba(59,126,248,0.08);
}

/* ── Buttons ── */
.btn-primary {
    background: var(--accent);
    color: white;
    border: none;
    padding: 13px 42px;
    border-radius: var(--radius-sm);
    font-family: var(--font-head);
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.4px;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 18px rgba(59,126,248,0.32);
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 6px 24px rgba(59,126,248,0.42);
}

.btn-primary:active { transform: translateY(0); }

.btn-add {
    background: var(--accent-lt);
    color: var(--accent);
    border: 1.5px solid rgba(59,126,248,0.25);
    padding: 9px 18px;
    border-radius: var(--radius-sm);
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 6px;
}

.btn-add:hover { background: #dbeafe; border-color: var(--accent); }

.btn-remove {
    background: #fef2f2;
    color: #dc2626;
    border: 1.5px solid #fecaca;
    padding: 8px 13px;
    border-radius: var(--radius-sm);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    flex-shrink: 0;
}

.btn-remove:hover { background: #fee2e2; border-color: #f87171; }

/* ── Internship position ── */
#positionField {
    display: none;
    margin-top: 16px;
    animation: slideIn 0.2s ease;
}

/* ── Submit ── */
.submit-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-top: 4px;
}
</style>

<div class="page-wrap">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h2>Student Profile</h2>
            <p>Keep your academic and personal information up to date</p>
        </div>
    </div>

    @if(session('success'))
    <div class="success-box">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
    @csrf

        {{-- ── PERSONAL DETAILS ── --}}
        <div class="card">
            <div class="section-title"><i class="fa-solid fa-id-card"></i> Personal Details</div>
            <div class="grid-2">

                <div class="field-group">
                    <label><i class="fa-solid fa-user"></i> Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Your full name">
                </div>

                <div class="field-group">
                    <label><i class="fa-solid fa-venus-mars"></i> Gender</label>
                    <select name="gender" class="form-control">
                        <option value="Male"   {{ ($profile->gender ?? '') == 'Male'   ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ ($profile->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="field-group">
                    <label><i class="fa-solid fa-mobile-screen"></i> Mobile</label>
                    <input type="text" name="mobile" value="{{ $profile->mobile ?? '' }}" class="form-control" placeholder="+91 00000 00000">
                </div>

                <div class="field-group">
                    <label><i class="fa-solid fa-envelope"></i> Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="you@example.com">
                </div>

                <div class="field-group">
                    <label><i class="fa-solid fa-cake-candles"></i> Date of Birth</label>
                    <input type="date" name="dob" value="{{ $profile->dob ?? '' }}" class="form-control">
                </div>

                <div class="field-group">
                    <label><i class="fa-solid fa-location-dot"></i> Address</label>
                    <input type="text" name="address" value="{{ $profile->address ?? '' }}" class="form-control" placeholder="Your address">
                </div>

            </div>
        </div>

        {{-- ── SKILLS ── --}}
        <div class="card">
            <div class="section-title">
                <i class="fa-solid fa-code"></i> Skills
            </div>

            <div class="field-group">
                <label>
                    <i class="fa-solid fa-tags"></i> Technical Skills
                </label>

              <textarea name="skills" 
                class="form-control" 
                rows="4"
                placeholder="e.g. Laravel, PHP, MySQL, JavaScript, React">{{ 
                isset($profile->skills) ? $profile->skills : '' }}</textarea>
            </div>
        </div>
    
        {{-- ── EDUCATIONAL DETAILS ── --}}
        <div class="card">
            <div class="section-title"><i class="fa-solid fa-graduation-cap"></i> Educational Details</div>

            <div class="edu-sub" style="margin-bottom:16px;"><i class="fa-solid fa-school"></i> SSC (10th)</div>
            <div class="grid-4" style="margin-bottom:28px;">
                <div class="field-group">
                    <label><i class="fa-solid fa-language"></i> Medium</label>
                    <input type="text" name="ssc_medium" value="{{ $profile->ssc_medium ?? '' }}" class="form-control" placeholder="e.g. English">
                </div>
                <div class="field-group">
                    <label><i class="fa-solid fa-building-columns"></i> School Name</label>
                    <input type="text" name="ssc_school" value="{{ $profile->ssc_school ?? '' }}" class="form-control" placeholder="School name">
                </div>
                <div class="field-group">
                    <label><i class="fa-solid fa-certificate"></i> Board</label>
                    <input type="text" name="ssc_board" value="{{ $profile->ssc_board ?? '' }}" class="form-control" placeholder="e.g. GSEB">
                </div>
                <div class="field-group">
                    <label><i class="fa-solid fa-percent"></i> % / CGPA</label>
                    <input type="text" name="ssc_percentage" value="{{ $profile->ssc_percentage ?? '' }}" class="form-control" placeholder="e.g. 85%">
                </div>
            </div>

            <div class="edu-sub" style="margin-bottom:16px;"><i class="fa-solid fa-school-flag"></i> HSC (12th)</div>
            <div class="grid-4" style="margin-bottom:28px;">
                <div class="field-group">
                    <label><i class="fa-solid fa-language"></i> Medium</label>
                    <input type="text" name="hsc_medium" value="{{ $profile->hsc_medium ?? '' }}" class="form-control" placeholder="e.g. English">
                </div>
                <div class="field-group">
                    <label><i class="fa-solid fa-building-columns"></i> School Name</label>
                    <input type="text" name="hsc_school" value="{{ $profile->hsc_school ?? '' }}" class="form-control" placeholder="School name">
                </div>
                <div class="field-group">
                    <label><i class="fa-solid fa-certificate"></i> Board</label>
                    <input type="text" name="hsc_board" value="{{ $profile->hsc_board ?? '' }}" class="form-control" placeholder="e.g. GSEB">
                </div>
                <div class="field-group">
                    <label><i class="fa-solid fa-percent"></i> % / CGPA</label>
                    <input type="text" name="hsc_percentage" value="{{ $profile->hsc_percentage ?? '' }}" class="form-control" placeholder="e.g. 85%">
                </div>
            </div>

            <div class="edu-sub" style="margin-bottom:16px;"><i class="fa-solid fa-university"></i> Current Education</div>
            <div class="grid-3">
                <div class="field-group">
                    <label><i class="fa-solid fa-book-open"></i> Current Program</label>
                    <input type="text" name="current_program" value="{{ $profile->current_program ?? '' }}" class="form-control" placeholder="e.g. B.Tech CS">
                </div>
                <div class="field-group">
                    <label><i class="fa-solid fa-layer-group"></i> Current Semester</label>
                    <input type="text" name="current_semester" value="{{ $profile->current_semester ?? '' }}" class="form-control" placeholder="e.g. Semester 5">
                </div>
                <div class="field-group">
                    <label><i class="fa-solid fa-star"></i> Current CGPA</label>
                    <input type="text" name="current_cgpa" value="{{ $profile->current_cgpa ?? '' }}" class="form-control" placeholder="e.g. 8.5">
                </div>
            </div>
        </div>

        {{-- ── CERTIFICATIONS ── --}}
        <div class="card">
            <div class="section-title"><i class="fa-solid fa-award"></i> Certifications</div>

            <div id="certificationContainer">
              @php
                $certifications = !empty($profile->certifications)
                    ? explode(',', $profile->certifications)
                    : [''];
              @endphp

                @foreach($certifications as $index => $cert)
                <div class="cert-item">
                    <span class="cert-number">{{ $index + 1 }}.</span>
                    <input type="text" name="certifications[]" value="{{ trim($cert) }}" class="form-control" placeholder="Certificate name or course title">
                    <button type="button" onclick="removeCertification(this)" class="btn-remove">
                        <i class="fa-solid fa-trash-can"></i> Remove
                    </button>
                </div>
                @endforeach
            </div>

            <button type="button" onclick="addCertification()" class="btn-add">
                <i class="fa-solid fa-plus"></i> Add Certification
            </button>
        </div>

        {{-- ── SEMINARS & ACHIEVEMENTS ── --}}
        <div class="card">
            <div class="section-title"><i class="fa-solid fa-microphone-lines"></i> Activities & Achievements</div>

            <div class="grid-2" style="margin-bottom:20px;">
                <div class="field-group">
                    <label><i class="fa-solid fa-chalkboard-user"></i> Seminars Attended</label>
                    <textarea name="seminars" class="form-control" rows="4" placeholder="List seminars, workshops, or events attended">{{ $profile->seminars ?? '' }}</textarea>
                </div>
            </div>

            <div class="field-group">
                <label><i class="fa-solid fa-medal"></i> Achievements</label>
                <textarea name="achievements" class="form-control" rows="4" placeholder="Awards, honours, recognitions, or notable accomplishments">{{ $profile->achievements ?? '' }}</textarea>
            </div>
        </div>

        {{-- ── INTERNSHIP ── --}}
        <div class="card">
            <div class="section-title"><i class="fa-solid fa-briefcase"></i> Internship</div>

            <div class="field-group" style="margin-bottom:6px;">
                <label style="margin-bottom:12px;"><i class="fa-solid fa-circle-question"></i> Currently Doing Internship?</label>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="is_interning" value="1" {{ ($profile->is_interning ?? 0) == 1 ? 'checked' : '' }}>
                        <span class="radio-dot"></span>
                        <i class="fa-solid fa-check-circle" style="color:var(--success);font-size:15px;"></i>
                        Yes, currently interning
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="is_interning" value="0" {{ ($profile->is_interning ?? 0) == 0 ? 'checked' : '' }}>
                        <span class="radio-dot"></span>
                        <i class="fa-solid fa-xmark-circle" style="color:var(--muted);font-size:15px;"></i>
                        No internship currently
                    </label>
                </div>
            </div>

            <div id="positionField">
                <div class="field-group">
                    <label><i class="fa-solid fa-user-tie"></i> Internship Position</label>
                    <input type="text" name="intern_position" value="{{ $profile->intern_position ?? '' }}" class="form-control" placeholder="e.g. Backend Developer Intern">
                </div>
            </div>
        </div>

        {{-- ── SUBMIT ── --}}
        <div class="submit-row">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Update Profile
            </button>
        </div>

    </form>
</div>

<script>
function previewPhoto(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('photoPreview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

document.addEventListener('DOMContentLoaded', function () {
    const yesRadio = document.querySelector('input[name="is_interning"][value="1"]');
    const noRadio  = document.querySelector('input[name="is_interning"][value="0"]');
    const positionField = document.getElementById('positionField');

    function togglePosition() {
        positionField.style.display = yesRadio.checked ? 'block' : 'none';
    }

    yesRadio.addEventListener('change', togglePosition);
    noRadio.addEventListener('change', togglePosition);
    togglePosition();

    updateNumbers();
});

function updateNumbers() {
    document.querySelectorAll('.cert-item').forEach((item, index) => {
        item.querySelector('.cert-number').innerText = (index + 1) + '.';
    });
}

function addCertification() {
    const container = document.getElementById('certificationContainer');
    const div = document.createElement('div');
    div.classList.add('cert-item');
    div.innerHTML = `
        <span class="cert-number"></span>
        <input type="text" name="certifications[]" class="form-control" placeholder="Certificate name or course title">
        <button type="button" onclick="removeCertification(this)" class="btn-remove">
            <i class="fa-solid fa-trash-can"></i> Remove
        </button>
    `;
    container.appendChild(div);
    updateNumbers();
    div.querySelector('input').focus();
}

function removeCertification(button) {
    button.parentElement.remove();
    updateNumbers();
}
</script>

@endsection