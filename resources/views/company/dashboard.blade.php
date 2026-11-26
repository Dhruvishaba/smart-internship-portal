

<style>
    :root {
        --primary: #4f46e5;
        --success: #10b981;
        --danger: #ef4444;
        --slate-50: #f8fafc;
        --slate-200: #e2e8f0;
        --slate-700: #334155;
        --slate-900: #0f172a;
    }

    body { background-color: var(--slate-50); font-family: 'Inter', system-ui, -apple-system, sans-serif; color: var(--slate-900); }
    .container-dashboard { max-width: 1200px; margin: 40px auto; padding: 0 20px; }

    /* Header Section */
    .glass-card {
        background: white;
        padding: 28px;
        border-radius: 20px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.04);
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Stats */
    .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px; }
    .stat-tile { background: white; padding: 20px; border-radius: 16px; border: 1px solid var(--slate-200); }
    .stat-tile small { color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
    .stat-tile h2 { font-size: 1.75rem; margin-top: 8px; color: var(--primary); }

    /* Modern Rows for Applications */
    .app-row {
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        border: 1px solid var(--slate-200);
        margin-bottom: 12px;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        align-items: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .app-row:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-color: var(--primary); }

    /* Buttons */
    .btn { padding: 10px 18px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; font-size: 0.9rem; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
    .btn-primary { background: var(--primary); color: white; }
    .btn-success { background: var(--success); color: white; }
    .btn-danger { background: var(--danger); color: white; }
    .btn-light { background: var(--slate-100); color: var(--slate-700); border: 1px solid var(--slate-200); }
    .btn-light:hover { background: #f1f5f9; }

    /* Side Drawer */
    .side-drawer {
        position: fixed;
        right: -550px;
        top: 0;
        width: 450px;
        height: 100vh;
        background: white;
        z-index: 2000;
        box-shadow: -10px 0 30px rgba(0,0,0,0.1);
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 40px;
        overflow-y: auto;
    }
    .side-drawer.active { right: 0; }
    .drawer-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); display: none; z-index: 1999; }

    /* Badge */
    .pill { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-approved { background: #dcfce7; color: #166534; }
    .status-rejected { background: #fee2e2; color: #991b1b; }
</style>

<div class="container-dashboard">
    
    @if(session('success'))
        <div style="background: var(--success); color: white; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass-card">
        <div>
            <h1 style="font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px;">{{ $company->company_name }} Dashboard</h1>
            <p style="color: #64748b; font-size: 0.9rem;">Manage your recruitment and student placements</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('internships.create') }}" class="btn btn-primary">+ Post Internship</a>
            <form method="POST" action="{{ route('logout') }}">@csrf <button class="btn btn-light">Logout</button></form>
        </div>
    </div>

    <div class="grid-stats">
        <div class="stat-tile"><small>Total Posts</small><h2>{{ $internships->count() }}</h2></div>
        <div class="stat-tile"><small>Total Applicants</small><h2>{{ $applications->count() }}</h2></div>
        <div class="stat-tile"><small>Pending Review</small><h2 style="color: var(--danger)">{{ $applications->where('status', 'pending')->count() }}</h2></div>
    </div>

    <div style="margin-bottom: 25px;">
        <button onclick="toggleApplications()" class="btn btn-light" id="toggleBtn" style="color: var(--primary); border-color: var(--primary);">
            📂 Show All Applications
        </button>
    </div>

     <div id="internship-list" style="margin-top: 40px;">
        <h3 style="margin-bottom: 20px; font-weight: 700;">Your Listings</h3>
        @foreach($internships as $internship)
            <div class="stat-tile" style="margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4 style="font-weight: 700;">{{ $internship->title }}</h4>
                    <p style="font-size: 0.85rem; color: #64748b;">Skills: {{ $internship->required_skills }}</p>
                </div>
                <span class="pill {{ \Carbon\Carbon::parse($internship->application_deadline)->isPast() ? 'status-rejected' : 'status-approved' }}">
                    {{ \Carbon\Carbon::parse($internship->application_deadline)->isPast() ? 'Closed' : 'Active' }}
                </span>
            </div>
        @endforeach
    </div>

    <div id="applications-section" style="display: none; animation: fadeIn 0.4s ease-out;">
        <h3 style="margin-bottom: 20px; font-weight: 700;">Student Applications</h3>
        @forelse($applications as $app)
            <div class="app-row">
                <div>
                    <div style="font-weight: 700; font-size: 1.05rem;">{{ $app->student->name }}</div>
                    <div style="font-size: 0.85rem; color: #64748b;">For: {{ $app->internship->title }}</div>
                </div>
                <div style="font-weight: 600;">GPA: {{ $app->student->current_cgpa ?? 'N/A' }}</div>
                <div>
                    <span class="pill status-{{ strtolower($app->status) }}">{{ $app->status }}</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button onclick="openProfile({{ json_encode($app->student) }})" class="btn btn-light">Profile</button>
                    
                    @if(strtolower($app->status) == 'pending')
                        <form action="{{ route('company.accept', $app->id) }}" method="POST">
                            @csrf 
                            <button class="btn btn-success" title="Approved">✔</button>
                        </form>
                        <form action="{{ route('company.reject', $app->id) }}" method="POST">
                            @csrf 
                            <button class="btn btn-danger" title="Rejected">✖</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p style="color: #64748b;">No applications received yet.</p>
        @endforelse
    </div>

   
</div>

<div class="drawer-overlay" id="drawerOverlay" onclick="closeProfile()"></div>
<div class="side-drawer" id="studentDrawer">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            <h2 id="d-name" style="font-weight: 800; font-size: 1.8rem; color: var(--primary);"></h2>
            <p id="d-program" style="color: #64748b; font-weight: 500;"></p>
        </div>
        <button onclick="closeProfile()" style="background: none; border: none; font-size: 2rem; cursor: pointer;">&times;</button>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
        <div style="background: var(--slate-50); padding: 15px; border-radius: 12px;">
            <small style="color: #94a3b8; font-weight: 700; text-transform: uppercase;">Current CGPA</small>
            <div id="d-cgpa" style="font-size: 1.25rem; font-weight: 800; margin-top: 5px;"></div>
        </div>
        <div style="background: var(--slate-50); padding: 15px; border-radius: 12px;">
            <small style="color: #94a3b8; font-weight: 700; text-transform: uppercase;">Semester</small>
            <div id="d-semester" style="font-size: 1.25rem; font-weight: 800; margin-top: 5px;"></div>
        </div>
    </div>

    <div style="margin-bottom: 25px;">
        <h4 style="font-weight: 700; margin-bottom: 10px;">Contact Info</h4>
        <p>📱 <span id="d-mobile"></span></p>
        <p>📍 <span id="d-address"></span></p>
    </div>

    <div style="margin-bottom: 25px;">
        <h4 style="font-weight: 700; margin-bottom: 10px;">Technical Skills</h4>
        <p id="d-skills" style="line-height: 1.6; color: var(--slate-700);"></p>
    </div>

    <div style="margin-bottom: 25px;">
        <h4 style="font-weight: 700; margin-bottom: 10px;">Achievements</h4>
        <p id="d-achievements" style="line-height: 1.6; color: var(--slate-700); font-size: 0.95rem;"></p>
    </div>
</div>

<script>
    function toggleApplications() {
        const section = document.getElementById('applications-section');
        const btn = document.getElementById('toggleBtn');
        const isHidden = section.style.display === 'none';
        
        section.style.display = isHidden ? 'block' : 'none';
        btn.innerText = isHidden ? '🔼 Hide Applications' : '📂 Show All Applications';
    }

    function openProfile(student) {
        document.getElementById('d-name').innerText = student.name || 'N/A';
        document.getElementById('d-program').innerText = student.current_program || 'N/A';
        document.getElementById('d-cgpa').innerText = student.current_cgpa || 'N/A';
        document.getElementById('d-semester').innerText = student.current_semester || 'N/A';
        document.getElementById('d-mobile').innerText = student.mobile || 'N/A';
        document.getElementById('d-address').innerText = student.address || 'N/A';
        document.getElementById('d-skills').innerText = student.skills || 'N/A';
        document.getElementById('d-achievements').innerText = student.achievements || 'N/A';

        document.getElementById('studentDrawer').classList.add('active');
        document.getElementById('drawerOverlay').style.display = 'block';
    }

    function closeProfile() {
        document.getElementById('studentDrawer').classList.remove('active');
        document.getElementById('drawerOverlay').style.display = 'none';
    }
</script>

