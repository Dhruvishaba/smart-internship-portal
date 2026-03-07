<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>

<style>

body{
margin:0;
font-family:Arial;
background:#f4f6f9;
}

.container{
display:flex;
}

/* SIDEBAR */

.sidebar{
width:250px;
background:#1e293b;
color:white;
min-height:100vh;
padding:20px;
}

.sidebar a{
display:block;
color:white;
padding:10px;
text-decoration:none;
border-radius:5px;
margin-bottom:10px;
}

.sidebar a:hover{
background:#334155;
}

.profile-top{
text-align:center;
margin-bottom:30px;
}

.profile-top img{
width:100px;
height:100px;
border-radius:50%;
object-fit:cover;
border:3px solid white;
}

/* MAIN */

.main{
flex:1;
padding:30px;
}

/* SEARCH */

.search-title{
font-size:22px;
font-weight:bold;
margin-bottom:15px;
}

.search-box{
display:flex;
gap:10px;
margin-bottom:30px;
}

.search-box input{
flex:1;
padding:12px;
border-radius:6px;
border:1px solid #ccc;
font-size:14px;
}

.search-box button{
background:#1a73e8;
color:white;
border:none;
padding:12px 25px;
border-radius:6px;
cursor:pointer;
font-size:14px;
}

.search-box button:hover{
background:#0f5bd3;
}

/* CARDS */

.cards{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
gap:20px;
}

.card{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 5px 10px rgba(0,0,0,0.1);
}

.card h3{
margin-top:0;
}

/* BADGE */

.badge{
padding:4px 8px;
border-radius:5px;
font-size:12px;
color:white;
}

.paid{
background:green;
}

.unpaid{
background:red;
}

/* BUTTONS */

.apply-btn{
background:#007bff;
color:white;
padding:8px 15px;
border:none;
border-radius:6px;
cursor:pointer;
margin-top:10px;
}

.apply-btn:hover{
background:#0056b3;
}

.applied{
background:gray;
padding:8px 15px;
border-radius:6px;
color:white;
display:inline-block;
margin-top:10px;
}

</style>

</head>

<body>

<div class="container">

<!-- SIDEBAR -->

<div class="sidebar">

<div class="profile-top">

<a href="{{ route('student.profile') }}">

<img src="{{ auth()->user()->profile_photo 
? asset('storage/'.auth()->user()->profile_photo) 
: 'https://via.placeholder.com/100' }}">

</a>

<h3>{{ auth()->user()->name }}</h3>

</div>

<a href="{{ route('student.dashboard') }}">Dashboard</a>

<a href="{{ route('student.profile') }}">My Profile</a>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button style="width:100%;background:#dc3545;color:white;padding:10px;border:none;border-radius:5px;">
Logout
</button>
</form>

</div>


<!-- MAIN -->

<div class="main">

<div class="search-title">
🔎 Search Internships
</div>

<form method="GET" action="{{ route('student.search') }}" class="search-box">

<input 
type="text" 
name="search" 
placeholder="Search by skills, location, company..."
>

<button type="submit">Search</button>

</form>


<!-- INTERNSHIPS -->

<div class="cards">

@forelse($internships as $internship)

<div class="card">

<h3>{{ $internship->title }}</h3>

<p><strong>Company:</strong> {{ $internship->company_name }}</p>

<p><strong>Skills:</strong> {{ $internship->required_skills }}</p>

<p><strong>Duration:</strong> {{ $internship->duration }}</p>

<p><strong>Location:</strong> {{ $internship->address }}</p>

<p><strong>Deadline:</strong> {{ $internship->application_deadline }}</p>

<p><strong>Spots:</strong> {{ $internship->spots_available }}</p>


@if($internship->stipend)
<span class="badge paid">Paid - ₹{{ $internship->stipend }}</span>
@else
<span class="badge unpaid">Unpaid</span>
@endif


@php
$applied = \App\Models\Application::where('internship_id',$internship->id)
->where('student_id',$student->id)
->exists();
@endphp


@if($applied)

<span class="applied">Already Applied</span>

@else

<form action="{{ route('apply.internship',$internship->id) }}" method="POST">
@csrf

<button class="apply-btn">
Apply Internship
</button>

</form>

@endif


</div>

@empty

<p>No internships available</p>

@endforelse

</div>

</div>

</div>

</body>
</html>