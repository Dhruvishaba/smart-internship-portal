@extends('layouts.app')

@section('content')

<style>

/* Container */
.container-box{
    max-width:1100px;
    margin:auto;
    padding:30px;
}

/* Header */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.logout-btn{
    background:#dc2626;
    color:white;
    padding:8px 16px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* Search */
.search-box{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

.search-box input{
    padding:10px;
    width:280px;
    border-radius:6px;
    border:1px solid #ccc;
}

.search-box button{
    background:#2563eb;
    color:white;
    padding:10px 15px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

/* Stats */
.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:30px;
}

.stat-box{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
    text-align:center;
}

/* Card */
.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
    margin-bottom:15px;
    transition:0.3s;
    position:relative;
    z-index:1;
}

.card:hover{
    z-index:1000;
}

/* Badges */
.badge{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.open{ background:#dcfce7; color:#16a34a; }
.closed{ background:#fee2e2; color:#dc2626; }

/* Status */
.status{
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.approved{ background:#dcfce7; color:#16a34a; }
.rejected{ background:#fee2e2; color:#dc2626; }
.pending{ background:#fef3c7; color:#d97706; }

/* Buttons */
.btn{
    padding:8px 16px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
}

.btn-accept{ background:#16a34a; color:white; }
.btn-reject{ background:#dc2626; color:white; }

/* Student Hover */
/* Student Hover */
.student-hover{
    position:relative;
    display:inline-block;
    cursor:pointer;
    color:#2563eb;
    font-weight:600;
}

/* FIXED CARD */
.student-card{
    display:none;
    position:absolute;
    top:30px;
    left:0;
    width:350px;
    max-height:420px;
    overflow-y:auto;
    background:#ffffff;
    padding:18px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    z-index:9999; /* increase */
}

/* SHOW ON HOVER */
.student-hover:hover .student-card{
    display:block;
}

/* SECTION DIVIDER */
.student-card hr{
    margin:10px 0;
    border:none;
    border-top:1px solid #e5e7eb;
}

/* TEXT IMPROVEMENT */
.student-card strong{
    color:#374151;
}

/* PREVENT OVERFLOW RIGHT SIDE */
.student-hover:last-child .student-card{
    left:auto;
    right:0;
}

</style>

<div class="container-box">

@if(session('success'))
<div style="background:#dcfce7;padding:10px;border-radius:6px;margin-bottom:15px;">
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background:#fee2e2;padding:10px;border-radius:6px;margin-bottom:15px;">
{{ session('error') }}
</div>
@endif

<!-- HEADER -->
<div class="header">
<h2>🏢 {{ $company->company_name }} Dashboard</h2>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="logout-btn">Logout</button>
</form>
</div>

<!-- SEARCH -->
<div class="search-box">
<h3>🔎 Search Students</h3>

<form action="{{ route('company.search') }}" method="GET">
<input type="text" name="search" placeholder="Search by skills, CGPA, location...">
<button type="submit">Search</button>
</form>
</div>

<!-- STATS -->
<div class="stats">

<div class="stat-box">
<h4>Total Internships</h4>
<h2>{{ $internships->count() }}</h2>
</div>

<div class="stat-box">
<h4>Total Applications</h4>
<h2>{{ $applications->count() }}</h2>
</div>

<div class="stat-box">
<h4>Matching Students</h4>
<h2>{{ $matchingStudents->count() }}</h2>
</div>

</div>

<!-- BUTTON -->
<div style="margin-bottom:25px;">
<a href="{{ route('internships.create') }}"
style="background:#16a34a;color:white;padding:10px 20px;border-radius:6px;text-decoration:none;">
+ Post Internship
</a>
</div>

<!-- INTERNSHIPS -->
<h3>📢 Your Posted Internships</h3>

@forelse($internships as $internship)

<div class="card">

<h4>{{ $internship->title }}</h4>

<p><strong>Skills:</strong> {{ $internship->required_skills ?? 'N/A' }}</p>
<p><strong>Duration:</strong> {{ $internship->duration }}</p>
<p><strong>Spots:</strong> {{ $internship->spots_available }}</p>

<p>
<strong>Status:</strong>

@if(\Carbon\Carbon::parse($internship->application_deadline)->isPast()
|| $internship->spots_available <= 0)

<span class="badge closed">Closed</span>

@else

<span class="badge open">Open</span>

@endif
</p>

</div>

@empty
<p>No internships posted yet.</p>
@endforelse

<br>

<!-- APPLICATIONS -->
<h3>📄 Student Applications</h3>

@forelse($applications as $application)

@php
$status = strtolower(trim($application->status));
@endphp

<div class="card">

<strong>Internship:</strong> {{ $application->internship->title ?? 'N/A' }}

<br><br>

<strong>Student:</strong>

<span class="student-hover">
{{ $application->student->name ?? 'N/A' }}

<div class="student-card">

{{-- BASIC --}}
<strong>Name:</strong> {{ $application->student->name ?? 'N/A' }} <br>
<strong>Gender:</strong> {{ $application->student->gender ?? 'N/A' }} <br>
<strong>Mobile:</strong> {{ $application->student->mobile ?? 'N/A' }} <br>
<strong>DOB:</strong> {{ $application->student->dob ?? 'N/A' }} <br>
<strong>Address:</strong> {{ $application->student->address ?? 'N/A' }} <br>

<hr>

{{-- EDUCATION --}}
<strong>🎓 Education</strong><br>

<strong>SSC:</strong> 
{{ $application->student->ssc_percentage ?? 'N/A' }} 
 <br>

<strong>HSC:</strong> 
{{ $application->student->hsc_percentage ?? 'N/A' }} 
 <br>

<strong>Program:</strong> {{ $application->student->current_program ?? 'N/A' }} <br>
<strong>Semester:</strong> {{ $application->student->current_semester ?? 'N/A' }} <br>
<strong>CGPA:</strong> {{ $application->student->current_cgpa ?? 'N/A' }} <br>

<hr>

{{-- SKILLS --}}
<strong>💻 Skills:</strong><br>
{{ $application->student->skills ?? 'N/A' }}

<hr>

{{-- ACTIVITIES --}}
<strong>🏆 Achievements:</strong><br>
{{ $application->student->achievements ?? 'N/A' }}

<br><br>

<strong>📢 Seminars:</strong><br>
{{ $application->student->seminars ?? 'N/A' }}

<hr>

{{-- INTERNSHIP --}}
<strong>💼 Internship Status:</strong>
@if($application->student->is_interning)
    Yes ({{ $application->student->intern_position ?? 'N/A' }})
@else
    No
@endif

</div>

</span>

<br><br>

<strong>Status:</strong>

@if($status == 'approved')
    <span class="status approved">Approved</span>

@elseif($status == 'rejected')
    <span class="status rejected">Rejected</span>

@else
    <span class="status pending">Pending</span>
@endif

<br><br>

@if($status == 'pending')

<form action="{{ route('company.accept', $application->id) }}" method="POST" style="display:inline;">
@csrf
<button class="btn btn-accept">✔ Approve</button>
</form>

<form action="{{ route('company.reject', $application->id) }}" method="POST" style="display:inline;">
@csrf
<button class="btn btn-reject">✖ Reject</button>
</form>

@endif

</div>

@empty
<p>No applications yet.</p>
@endforelse

</div>

@endsection