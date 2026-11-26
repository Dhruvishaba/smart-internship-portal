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
        --font-head: 'Poppins', sans-serif;
        --font-body: 'Inter', sans-serif;
        --radius:     14px;
        --radius-sm:  8px;
        --shadow:     0 4px 24px rgba(59,126,248,0.08), 0 1px 4px rgba(0,0,0,0.06);
    }

    body {
        background: var(--bg);
        font-family: var(--font-body);
        color: var(--text);
    }

    .page-wrap {
        max-width: 850px;
        margin: auto;
        position: relative;
        z-index: 1;
        padding-bottom: 50px;
    }

    .page-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 32px;
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
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 32px 36px;
        margin-bottom: 22px;
        box-shadow: var(--shadow);
    }

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

    .field-group { margin-bottom: 20px; }
    
    label {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: var(--label);
        display: flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .form-control {
        background: var(--surface2);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 12px 15px;
        color: var(--text);
        font-family: var(--font-body);
        font-size: 14px;
        width: 100%;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(59,126,248,0.1);
    }

    .hint { font-size: 11px; color: var(--muted); margin-top: 5px; display: block; }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

    .alert {
        padding: 14px 18px;
        border-radius: var(--radius-sm);
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
    }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
    .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

    .btn-submit {
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        color: white;
        border: none;
        padding: 14px 36px;
        border-radius: var(--radius-sm);
        font-family: var(--font-head);
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 15px rgba(59,126,248,0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59,126,248,0.4);
    }

    @media (max-width: 768px) {
        .grid-2, .grid-3 { grid-template-columns: 1fr; }
    }
</style>

<div class="page-wrap">

    <div class="page-header">
        <div>
            <h2>Post New Internship</h2>
            <p>Fill in the details to find the best student talent</p>
        </div>
    </div>

    @php 
        // Logic: Tomorrow is the earliest selectable date
        $tomorrow = date('Y-m-d', strtotime('+1 day')); 
    @endphp

    {{-- Notifications --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any() || session('error'))
        <div class="alert alert-danger">
            @if(session('error')) {{ session('error') }} @endif
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('internships.store') }}">
        @csrf

        {{-- BASIC INFORMATION --}}
        <div class="card">
            <div class="section-title">Basic Information</div>
            
            <div class="field-group">
                <label>Internship Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="e.g. Laravel Developer Intern" required>
            </div>

            <div class="field-group">
                <label>Job Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe the roles and responsibilities..." required>{{ old('description') }}</textarea>
            </div>

            <div class="field-group">
                <label>Required Skills</label>
                <input type="text" name="required_skills" value="{{ old('required_skills') }}" class="form-control" placeholder="laravel, php, mysql, javascript" required>
                <span class="hint">Separate multiple skills with commas</span>
            </div>
        </div>

        {{-- LOGISTICS & DATES --}}
        <div class="card">
            <div class="section-title">Timeline & Logistics</div>
            
            <div class="grid-3">
                <div class="field-group">
                    <label>Duration</label>
                    <input type="text" name="duration" value="{{ old('duration') }}" class="form-control" placeholder="e.g. 3 Months" required>
                </div>
                <div class="field-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control" min="{{ $tomorrow }}" required>
                </div>
                <div class="field-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control" min="{{ $tomorrow }}" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="field-group">
                    <label>Stipend (Monthly)</label>
                    <input type="number" name="stipend" value="{{ old('stipend') }}" class="form-control" placeholder="5000" required>
                </div>
                <div class="field-group">
                    <label>Available Spots</label>
                    <input type="number" name="spots_available" value="{{ old('spots_available') }}" class="form-control" min="1" placeholder="5" required>
                </div>
            </div>

            <div class="field-group">
                <label>Internship Location</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Office address or 'Remote'" required>{{ old('address') }}</textarea>
            </div>
        </div>

        {{-- ELIGIBILITY & DEADLINE --}}
        <div class="card">
            <div class="section-title">Eligibility & Deadline</div>
            
            <div class="field-group">
                <label>Eligibility Criteria</label>
                <textarea name="eligibility" class="form-control" rows="3" placeholder="Specify education requirements..." required>{{ old('eligibility') }}</textarea>
            </div>

            <div class="field-group">
                <label>Application Deadline</label>
                <input type="date" name="application_deadline" value="{{ old('application_deadline') }}" class="form-control" min="{{ $tomorrow }}" required>
                <span class="hint">Must be at least tomorrow</span>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn-submit">
                🚀 Post Internship
            </button>
        </div>

    </form>
</div>

@endsection