
<style>
      :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-main: #f8fafc;
            --sidebar-bg: #0f172a;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04);
            --success: #10b981;
            --danger: #ef4444;
      }

      body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: #1e293b;
      }

      /* ===== SIDEBAR FIX ===== */
      .sidebar {
            top: 0;
            position: fixed;
            left: 0;
            width: 260px;
            height: 100vh;
            /* Fixed: Changed from 200px to full screen */
            background: var(--sidebar-bg);
            color: white;
            padding: 30px 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
      }

      .profile-top {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .sidebar nav {
            flex-grow: 1;
      }

      .sidebar nav a {
            display: flex;
            align-items: center;
            color: #94a3b8;
            padding: 14px 18px;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 8px;
            font-weight: 500;
            transition: 0.3s;
      }

      .sidebar nav a:hover,
      .sidebar nav a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
      }

      .logout-btn {
            background: rgba(220, 38, 38, 0.1);
            color: #ef4444;
            padding: 12px;
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            margin-top: auto;
      }

      /* ===== MAIN CONTENT ===== */
      .main {
            margin-left: 260px;
            /* Aligned with sidebar width */
            padding: 40px;
      }

      /* ===== DYNAMIC STATS ===== */
      .stats-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
      }

      .stat-badge {
            background: white;
            padding: 15px 25px;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
      }

      .stat-badge small {
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
      }

      .stat-badge span {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
      }

      .search-box {
            flex: 1;
            display: flex;
            background: white;
            padding: 8px;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: 1px solid #e2e8f0;
      }

      .search-box input {
            flex: 1;
            padding: 10px 15px;
            border: none;
            outline: none;
            background: transparent;
      }

      .search-box button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
      }

      /* ===== CARDS & SLIDER ===== */
      .slider {
            position: relative;
            height: 250px;
            border-radius: 24px;
            overflow: hidden;
            margin-bottom: 40px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
      }

      .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            display: none;
            padding: 50px;
            box-sizing: border-box;
            color: white;
            background-size: cover;
            background-position: center;
      }

      .slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(15, 23, 42, 0.8) 0%, transparent 100%);
            z-index: 1;
      }

      .slide.active {
            display: flex;
            flex-direction: column;
            justify-content: center;
      }

      .slide h3,
      .slide p {
            position: relative;
            z-index: 2;
            margin: 5px 0;
      }

      .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
      }

      .card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            transition: 0.3s ease;
            display: flex;
            flex-direction: column;
      }

      .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
      }

      .card h3 {
            margin: 0 0 15px 0;
            font-weight: 700;
            color: var(--sidebar-bg);
      }

      .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
      }

      .paid {
            background: #dcfce7;
            color: #16a34a;
      }

      .unpaid {
            background: #fee2e2;
            color: #dc2626;
      }

      .apply-btn {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 15px;
      }

      /* ===== POPUP ===== */
      .popup {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(4px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
      }

      .popup-box {
            background: white;
            padding: 40px;
            border-radius: 24px;
            width: 350px;
            text-align: center;
      }
</style>

<div class="sidebar">
      <div class="profile-top">
            <h3>{{ Auth::user()->name }}</h3>
      </div>
      <nav>
            <a href="{{ route('student.dashboard') }}" class="active">Dashboard</a>
            <a href="{{ route('student.profile') }}">My Profile</a>
            <a href="{{ route('student.applications') }}">My Applications</a>
      </nav>
      <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
      </form>
</div>

<div class="main">
      <div class="stats-header">
            

            <form method="GET" action="{{ route('student.search') }}" class="search-box">
                  <input type="text" name="search" placeholder="Search skills, roles, companies...">
                  <button type="submit">Find Now</button>
            </form>
      </div>

      <div class="slider">
            <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d')">
                  <h3>🚀 Fast-Track Your Career</h3>
                  <p>Apply to 50+ new openings today.</p>
            </div>
            <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d')">
                  <h3>💼 Industry Experience</h3>
                  <p>Work with top-tier companies.</p>
            </div>
            <button class="slider-btn prev" style="left:10px; position:absolute; top:50%; z-index:10;" onclick="prevSlide()">‹</button>
            <button class="slider-btn next" style="right:10px; position:absolute; top:50%; z-index:10;" onclick="nextSlide()">›</button>
      </div>

      <div class="cards">
            @forelse($internships as $internship)
            <div class="card">
                  <h3>{{ $internship->title }}</h3>
                  <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 5px;"><strong>🏢</strong> {{ $internship->company->company_name ?? 'N/A' }}</p>
                  <p style="font-size: 0.9rem; color: #64748b;"><strong>💻</strong> {{ $internship->required_skills }}</p>
                  <p style="font-size: 0.9rem; color: #64748b;"><strong>📍</strong> {{ $internship->address }}</p>
                  <p style="font-size: 0.9rem; color: #64748b;"><strong>📅 Deadline: {{ \Carbon\Carbon::parse($internship->application_deadline)->format('d M Y') }}</strong></p>
                  <div style="margin: 15px 0;">
                        @if($internship->stipend)
                        <span class="badge paid">₹{{ $internship->stipend }}</span>
                        @else
                        <span class="badge unpaid">Unpaid</span>
                        @endif
                        <span style="font-size: 0.75rem; color: #94a3b8; margin-left: 10px;">{{ $internship->spots_available }} spots left</span>
                  </div>

                  @if(\Carbon\Carbon::parse($internship->application_deadline)->isPast() || $internship->spots_available <= 0)
                        <button class="apply-btn" style="background: #e2e8f0; color: #94a3b8; cursor:not-allowed;" disabled>Closed</button>
                        @else
                        <form id="applyForm{{ $internship->id }}" action="{{ route('student.apply',$internship->id) }}" method="POST">
                              @csrf
                              <button type="button" onclick="checkSkill('{{ $internship->id }}')" class="apply-btn">Apply Now</button>
                        </form>
                        @endif
            </div>
            @empty
            <p>No internships available at the moment.</p>
            @endforelse
      </div>
</div>

<div id="skillPopup" class="popup">
      <div class="popup-box">
            <h3 style="color:var(--danger); margin-bottom: 10px;">Skill Mismatch</h3>
            <p id="popupMessage" style="color: #64748b; margin-bottom: 25px;"></p>
            <button onclick="closePopup()" class="apply-btn">Close</button>
      </div>
</div>

<script>
      let currentSlide = 0;
      const slides = document.querySelectorAll(".slide");

      function showSlide(index) {
            slides.forEach(s => s.classList.remove("active"));
            slides[index].classList.add("active");
      }

      function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
      }

      function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
      }

      setInterval(nextSlide, 5000);

      function checkSkill(id) {
    fetch("/student/check-skill/" + id)
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                document.getElementById("applyForm" + id).submit();
            } else {
                document.getElementById("popupMessage").innerText =
                    data.message + " (Match: " + data.match + "%)";
                document.getElementById("skillPopup").style.display = "flex";
            }
        });
}

      function closePopup() {
            document.getElementById("skillPopup").style.display = "none";
      }
</script>
