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

.main{
flex:1;
padding:30px;
}

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
}

.search-box button{
background:#1a73e8;
color:white;
border:none;
padding:12px 25px;
border-radius:6px;
cursor:pointer;
}

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

.badge{
padding:4px 8px;
border-radius:5px;
font-size:12px;
color:white;
}

.paid{background:green;}
.unpaid{background:red;}
.closed{background:#dc3545;}

.apply-btn{
background:#007bff;
color:white;
padding:8px 15px;
border:none;
border-radius:6px;
cursor:pointer;
margin-top:10px;
}

.popup{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.6);
justify-content:center;
align-items:center;
}

.popup-box{
background:white;
padding:30px;
border-radius:10px;
width:400px;
text-align:center;
}

.close-btn{
background:red;
color:white;
border:none;
padding:10px 20px;
margin-top:20px;
cursor:pointer;
}

</style>
</head>

<body>

<div class="container">

<div class="sidebar">

<div class="profile-top">
<h3>{{ Auth::user()->name }}</h3>
</div>

<a href="{{ route('student.dashboard') }}">Dashboard</a>
<a href="{{ route('student.profile') }}">My Profile</a>
<a href="{{ route('student.applications') }}">My Applications</a>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button style="width:100%;background:#dc3545;color:white;padding:10px;border:none;border-radius:5px;">
Logout
</button>
</form>

</div>

<div class="main">

<div class="search-title">🔎 Search Internships</div>

<form method="GET" action="{{ route('student.search') }}" class="search-box">
<input type="text" name="search" placeholder="Search by skills, location, company...">
<button type="submit">Search</button>
</form>

<div class="cards">

@forelse($internships as $internship)

<div class="card">

<h3>{{ $internship->title }}</h3>

<p><strong>Company:</strong> {{ $internship->company->company_name ?? 'N/A' }}</p>

<p><strong>Skills:</strong> {{ $internship->required_skills }}</p>

<p><strong>Duration:</strong> {{ $internship->duration }}</p>
<p><strong>Location:</strong> {{ $internship->address }}</p>
<p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($internship->application_deadline)->format('d M Y') }}</p>
<p><strong>Spots Available:</strong> {{ $internship->spots_available }}</p>

@php
$deadlinePassed = \Carbon\Carbon::parse($internship->application_deadline)->isPast();
$spotsFull = $internship->spots_available <= 0;
@endphp

@if($internship->stipend)
<span class="badge paid">Paid ₹{{ $internship->stipend }}</span>
@else
<span class="badge unpaid">Unpaid</span>
@endif

<br><br>

@if($deadlinePassed || $spotsFull)

<span class="badge closed">Closed</span>

@else

<form id="applyForm{{ $internship->id }}" 
      action="{{ route('student.apply',$internship->id) }}" 
      method="POST">
@csrf

<button type="button"
        onclick="checkSkill('{{ $internship->id }}')"
        class="apply-btn">
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

<!-- POPUP -->

<div id="skillPopup" class="popup">

<div class="popup-box">

<h2 style="color:red;">Skill Not Matched</h2>

<p id="popupMessage"></p>

<button onclick="closePopup()" class="close-btn">Close</button>

</div>

</div>

<script>

function checkSkill(id){

fetch("/student/check-skill/" + id)
.then(response => response.json())
.then(data => {

if(data.status === "success"){

document.getElementById("applyForm"+id).submit();

}
else{

document.getElementById("popupMessage").innerHTML =
data.message;

document.getElementById("skillPopup").style.display="flex";

}

})
.catch(error => {

alert("Something went wrong");

});

}

function closePopup(){
document.getElementById("skillPopup").style.display="none";
}

</script>

</body>
</html>