<!DOCTYPE html>
<html>

<head>
<title>Student Dashboard</title>

<style>

/* ===== GLOBAL ===== */
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f1f5f9;
}

/* ===== SIDEBAR (FIXED) ===== */
.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:240px;
    height:100%;
    background:#0f172a;
    color:white;
    padding:20px;
    box-sizing:border-box;
}

.profile-top{
    text-align:center;
    margin-bottom:30px;
}

.profile-top h3{
    margin:0;
    font-size:18px;
}

.sidebar a{
    display:block;
    color:#cbd5e1;
    padding:12px;
    text-decoration:none;
    border-radius:6px;
    margin-bottom:10px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1e293b;
    color:white;
}

.sidebar button{
    width:100%;
    background:#dc2626;
    color:white;
    padding:10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    margin-top:20px;
}

/* ===== MAIN (SHIFTED) ===== */
.main{
    margin-left:240px;
    padding:25px;
}

/* ===== HEADER ===== */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header h2{
    margin:0;
}

/* ===== SEARCH ===== */
.search-box{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.search-box input{
    flex:1;
    padding:12px;
    border-radius:6px;
    border:1px solid #ccc;
}

.search-box button{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:6px;
    cursor:pointer;
}

/* ===== SLIDER ===== */
.slider{
    position:relative;
    height:250px;
    border-radius:10px;
    overflow:hidden;
    margin-bottom:25px;
}

.slide{
    position:absolute;
    width:100%;
    height:100%;
    display:none;
    padding:45px;
    color:white;
}

.slide:nth-child(1){
    background-image:url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d');
}

.slide:nth-child(2){
    background-image:url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d');
}

.slide:nth-child(3){
    background-image:url('https://images.unsplash.com/photo-1498050108023-c5249f4df085');
}


.slide.active{
    display:block;
}

.slider-btn{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    background:white;
    border:none;
    padding:6px 10px;
    cursor:pointer;
    border-radius:4px;
}

.prev{ left:10px; }
.next{ right:10px; }

/* ===== CARDS ===== */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 6px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-4px);
}

.card h3{
    margin-top:0;
    font-size:18px;
}

/* ===== BADGES ===== */
.badge{
    padding:5px 10px;
    border-radius:5px;
    font-size:12px;
    color:white;
}

.paid{ background:#16a34a; }
.unpaid{ background:#dc2626; }
.closed{ background:#6b7280; }

/* ===== BUTTON ===== */
.apply-btn{
    width:100%;
    padding:10px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.apply-btn:hover{
    background:#1d4ed8;
}

/* ===== POPUP ===== */
.popup{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    justify-content:center;
    align-items:center;
}

.popup-box{
    background:white;
    padding:25px;
    border-radius:10px;
    width:320px;
    text-align:center;
}

.close-btn{
    background:#dc2626;
    color:white;
    border:none;
    padding:10px;
    border-radius:5px;
    cursor:pointer;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<div class="profile-top">
<h3>{{ Auth::user()->name }}</h3>
</div>

<a href="{{ route('student.dashboard') }}">Dashboard</a>
<a href="{{ route('student.profile') }}">My Profile</a>
<a href="{{ route('student.applications') }}">My Applications</a>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button>Logout</button>
</form>

</div>

<!-- MAIN -->
<div class="main">

<div class="header">
<h2>Student Dashboard</h2>
</div>

<!-- SEARCH -->
<form method="GET" action="{{ route('student.search') }}" class="search-box">
<input type="text" name="search" placeholder="Search internships...">
<button type="submit">Search</button>
</form>

<!-- SLIDER -->
<div class="slider">

<div class="slide active">
<h3>🚀 Find Internships Easily</h3>
<p>Search and apply in one click</p>
</div>

<div class="slide">
<h3>💼 Gain Experience</h3>
<p>Build real-world skills</p>
</div>

<div class="slide">
<h3>🔥 Smart Matching</h3>
<p>Get internships based on your skills</p>
</div>

<button class="slider-btn prev" onclick="prevSlide()">‹</button>
<button class="slider-btn next" onclick="nextSlide()">›</button>

</div>

<!-- CARDS -->
<div class="cards">

@forelse($internships as $internship)

<div class="card">

<h3>{{ $internship->title }}</h3>

<p><strong>Company:</strong> {{ $internship->company->company_name ?? 'N/A' }}</p>
<p><strong>Skills:</strong> {{ $internship->required_skills }}</p>
<p><strong>Location:</strong> {{ $internship->address }}</p>
<p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($internship->application_deadline)->format('d M Y') }}</p>

@php
$deadlinePassed = \Carbon\Carbon::parse($internship->application_deadline)->isPast();
$spotsFull = $internship->spots_available <= 0;
@endphp

@if($internship->stipend)
<span class="badge paid">₹{{ $internship->stipend }}</span>
@else
<span class="badge unpaid">Unpaid</span>
@endif

<br><br>

@if($deadlinePassed || $spotsFull)
<span class="badge closed">Closed</span>
@else

<form id="applyForm{{ $internship->id }}" 
action="{{ route('student.apply',$internship->id) }}" method="POST">
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

<!-- POPUP -->
<div id="skillPopup" class="popup">
<div class="popup-box">
<h3 style="color:#dc2626;">Skill Not Matched</h3>
<p id="popupMessage"></p>
<button onclick="closePopup()" class="close-btn">Close</button>
</div>
</div>

<script>

/* SLIDER */
let currentSlide = 0;
const slides = document.querySelectorAll(".slide");

function showSlide(index){
slides.forEach(s => s.classList.remove("active"));
slides[index].classList.add("active");
}

function nextSlide(){
currentSlide = (currentSlide + 1) % slides.length;
showSlide(currentSlide);
}

function prevSlide(){
currentSlide = (currentSlide - 1 + slides.length) % slides.length;
showSlide(currentSlide);
}

setInterval(nextSlide, 4000);

/* SKILL CHECK */
function checkSkill(id){
fetch("/student/check-skill/" + id)
.then(res => res.json())
.then(data => {
if(data.status === "success"){
document.getElementById("applyForm"+id).submit();
}else{
document.getElementById("popupMessage").innerHTML = data.message;
document.getElementById("skillPopup").style.display="flex";
}
})
.catch(() => alert("Error"));
}

function closePopup(){
document.getElementById("skillPopup").style.display="none";
}

</script>

</body>
</html>