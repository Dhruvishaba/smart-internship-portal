@extends('layouts.app')

@section('content')

<div style="max-width:1100px;margin:auto;padding:30px;">

<!-- HEADER -->
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;">
    <h2>🏢 Company Dashboard</h2>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button style="background:#dc3545;color:white;padding:8px 15px;border:none;border-radius:5px;">
            Logout
        </button>
    </form>
</div>


<!-- SEARCH STUDENTS -->
<div style="background:#f4f6f9;padding:20px;border-radius:10px;margin-bottom:25px;">

<h3>🔎 Search Students</h3>

<form action="{{ route('company.search') }}" method="GET" style="display:flex;gap:10px;">
<input type="text" name="keyword" placeholder="Search by skills, location, CGPA..."
style="flex:1;padding:10px;border:1px solid #ccc;border-radius:5px;">

<button style="background:#007bff;color:white;border:none;padding:10px 20px;border-radius:5px;">
Search
</button>
</form>

</div>


<!-- DASHBOARD STATS -->
<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-bottom:30px;">

<div style="background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px #ddd;">
<h4>Total Internships</h4>
<h2>{{ $internships->count() }}</h2>
</div>

<div style="background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px #ddd;">
<h4>Total Applications</h4>
<h2>{{ $applications->count() }}</h2>
</div>

<div style="background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px #ddd;">
<h4>Matching Students</h4>
<h2>{{ $matchingStudents }}</h2>
</div>

</div>


<!-- POST INTERNSHIP BUTTON -->

<div style="margin-bottom:30px;">
<a href="{{ route('internships.create') }}"
style="background:#28a745;color:white;padding:10px 20px;border-radius:6px;text-decoration:none;">
+ Post Internship
</a>
</div>



<!-- POSTED INTERNSHIPS -->

<h3 style="margin-bottom:15px;">📢 Your Posted Internships</h3>

@forelse($internships as $internship)

<div style="background:white;padding:20px;border-radius:10px;margin-bottom:15px;box-shadow:0 0 10px #eee;">

<h4>{{ $internship->title }}</h4>

<p>
<strong>Skills:</strong> {{ $internship->required_skills }} <br>
<strong>Duration:</strong> {{ $internship->duration }} <br>
<strong>Spots:</strong> {{ $internship->spots_available }}
</p>

</div>

@empty

<p>No internships posted yet.</p>

@endforelse



<br><br>


<!-- APPLICATIONS SECTION -->

<h3 style="margin-bottom:15px;">📄 Student Applications</h3>

@forelse($applications as $application)

<div style="background:white;padding:20px;border-radius:10px;margin-bottom:15px;box-shadow:0 0 10px #eee;">

<strong>Internship:</strong>
{{ $application->internship->title }}

<br>

<strong>Student:</strong>
{{ $application->student->name ?? 'N/A' }}

<br>

<strong>Status:</strong>

@if($application->status == 'Accepted')
<span style="color:green;">Accepted</span>

@elseif($application->status == 'Rejected')
<span style="color:red;">Rejected</span>

@else
<span style="color:orange;">Pending</span>
@endif


<br><br>

@if($application->status == 'Pending')

<form action="{{ route('application.accept',$application->id) }}" method="POST" style="display:inline;">
@csrf
<button style="background:green;color:white;padding:6px 12px;border:none;border-radius:5px;">
Accept
</button>
</form>

<form action="{{ route('application.reject',$application->id) }}" method="POST" style="display:inline;">
@csrf
<button style="background:red;color:white;padding:6px 12px;border:none;border-radius:5px;">
Reject
</button>
</form>

@endif

</div>

@empty

<p>No student applications yet.</p>

@endforelse


</div>

@endsection