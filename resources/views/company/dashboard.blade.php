@extends('layouts.app')

@section('content')

<style>
.student-hover{
    position:relative;
    display:inline-block;
    cursor:pointer;
    color:#007bff;
    font-weight:600;
}

.student-card{
    display:none;
    position:absolute;
    bottom:30px;
    left:0;
    background:white;
    width:350px;
    padding:20px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,0.2);
    z-index:100;
}

.student-hover:hover .student-card{
    display:block;
}

.stat-box{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px #ddd;
    text-align:center;
}

.badge-open{
    color:green;
    font-weight:bold;
}

.badge-closed{
    color:red;
    font-weight:bold;
}
</style>

<div style="max-width:1100px;margin:auto;padding:30px;">

    @if(session('success'))
        <div style="background:#d4edda;padding:10px;border-radius:5px;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#f8d7da;padding:10px;border-radius:5px;margin-bottom:15px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;">
        <h2>🏢 {{ $company->company_name }} Dashboard (IT Manager)</h2>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button style="background:#dc3545;color:white;padding:8px 15px;border:none;border-radius:5px;">
                Logout
            </button>
        </form>
    </div>

    <!-- Search -->
    <div style="background:#f4f6f9;padding:20px;border-radius:10px;margin-bottom:25px;">
        <h3>🔎 Search Students</h3>

        <form action="{{ route('company.search') }}" method="GET">
            <input type="text"
                   name="search"
                   placeholder="Search by Name, Skills, CGPA, Location, Certification"
                   style="width:300px;padding:8px;">

            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Stats -->
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-bottom:30px;">

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

    <!-- Post Internship Button -->
    <div style="margin-bottom:30px;">
        <a href="{{ route('internships.create') }}"
           style="background:#28a745;color:white;padding:10px 20px;border-radius:6px;text-decoration:none;">
           + Post Internship
        </a>
    </div>

    <!-- Posted Internships -->
    <h3 style="margin-bottom:15px;">📢 Your Posted Internships</h3>

    @forelse($internships as $internship)

        <div style="background:white;padding:20px;border-radius:10px;margin-bottom:15px;box-shadow:0 0 10px #eee;">

            <h4>{{ $internship->title }}</h4>

            @php
                $skills = $internship->required_skills ?? '';

                if (is_string($skills)) {
                    $skills = array_map('trim', explode(',', $skills));
                } else {
                    $skills = [];
                }
            @endphp

           

<p>
    <strong>Skills:</strong>

    @if(count($skills) > 0)
        {{ implode(', ', $skills) }}
    @else
        Not specified
    @endif

    <br><br>

    <strong>Duration:</strong> {{ $internship->duration }} <br>
    <strong>Spots Available:</strong> {{ $internship->spots_available }} <br>
    <strong>Deadline:</strong> {{ \Carbon\Carbon::parse($internship->application_deadline)->format('d M Y') }}
</p>

            <p>
                <strong>Status:</strong>

                @if(\Carbon\Carbon::parse($internship->application_deadline)->isPast()
                    || $internship->spots_available <= 0)

                    <span class="badge-closed">Closed</span>

                @else

                    <span class="badge-open">Open</span>

                @endif
            </p>

        </div>

    @empty
        <p>No internships posted yet.</p>
    @endforelse

    <br><br>

    <!-- Student Applications -->
    <h3 style="margin-bottom:15px;">📄 Student Applications</h3>

    @forelse($applications as $application)

        <div style="background:white;padding:20px;border-radius:10px;margin-bottom:15px;box-shadow:0 0 10px #eee;">

            <strong>Internship:</strong>
            {{ $application->internship->title ?? 'N/A' }}

            <br><br>

            <strong>Student:</strong>

            <span class="student-hover">
                {{ $application->student->name ?? 'N/A' }}

                <div class="student-card">

                    <h4>Student Profile</h4>

                    <strong>Name:</strong> {{ $application->student->name ?? 'N/A' }} <br>
                    <strong>Gender:</strong> {{ $application->student->gender ?? 'N/A' }} <br>
                    <strong>Mobile:</strong> {{ $application->student->mobile ?? 'N/A' }} <br>
                    <strong>Address:</strong> {{ $application->student->address ?? 'N/A' }} <br><br>

                    <strong>Program:</strong> {{ $application->student->current_program ?? 'N/A' }} <br>
                    <strong>Semester:</strong> {{ $application->student->current_semester ?? 'N/A' }} <br>
                    <strong>CGPA:</strong> {{ $application->student->current_cgpa ?? 'N/A' }} <br><br>

                    @php
                        $stuSkills = $application->student->skills ?? '';

                        if (is_string($stuSkills)) {
                            $stuSkills = array_map('trim', explode(',', $stuSkills));
                        } else {
                            $stuSkills = [];
                        }
                    @endphp

                    <strong>Skills:</strong>
                    {{ implode(', ', $stuSkills) ?: 'N/A' }}

                    <br><br>

                    <strong>Certifications:</strong> {{ $application->student->certifications ?? 'N/A' }} <br><br>
                    <strong>Seminars:</strong> {{ $application->student->seminars ?? 'N/A' }} <br><br>
                    <strong>Achievements:</strong> {{ $application->student->achievements ?? 'N/A' }}

                </div>
            </span>

            <br><br>

            <strong>Status:</strong>

            @if($application->status == 'hired')
                <span style="color:green;font-weight:bold;">Hired</span>

            @elseif($application->status == 'rejected')
                <span style="color:red;font-weight:bold;">Rejected</span>

            @else
                <span style="color:orange;font-weight:bold;">Pending</span>
            @endif

            <br><br>

          @if(strtolower($application->status) == 'pending')

    <div style="margin-top:12px;">

        <!-- ACCEPT BUTTON -->
        <form action="{{ route('company.accept', $application->id) }}"
              method="POST"
              style="display:inline;">
            @csrf

            <button type="submit"
                onclick="return confirm('Are you sure you want to accept this student?')"
                style="background-color:#28a745;color:white;padding:8px 16px;border:none;border-radius:6px;cursor:pointer;font-weight:600;">
                ✔ Accept
            </button>
        </form>

        <!-- REJECT BUTTON -->
        <form action="{{ route('company.reject', $application->id) }}"
              method="POST"
              style="display:inline;margin-left:10px;">
            @csrf

            <button type="submit"
                onclick="return confirm('Are you sure you want to reject this student?')"
                style="background-color:#dc3545;color:white;padding:8px 16px;border:none;border-radius:6px;cursor:pointer;font-weight:600;">
                ✖ Reject
            </button>
        </form>

    </div>

@endif

    

        </div>

    @empty
        <p>No student applications yet.</p>
    @endforelse

</div>

@endsection