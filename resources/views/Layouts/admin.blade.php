<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

    <style>
        body{
            margin:0;
            font-family: Arial;
            background:#f4f6f9;
        }

        .navbar{
            background:#2c3e50;
            padding:15px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .nav-links a{
            color:white;
            margin-right:20px;
            text-decoration:none;
            font-size:16px;
        }

        .logout-btn button{
            background:red;
            color:white;
            border:none;
            padding:6px 12px;
            cursor:pointer;
        }

        .container{
            padding:20px;
        }
    </style>
</head>

<body>

<div class="navbar">

    <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.students') }}">Students</a>
        <a href="{{ route('admin.companies') }}">Companies</a>
        <a href="{{ route('admin.internships') }}">Internships</a>
        <a href="{{ route('admin.applications') }}">Applications</a>
        <a href="{{ route('admin.reports') }}">Reports</a>
    </div>

    <div class="logout-btn">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

</div>

<div class="container">
    @yield('content')
</div>

</body>
</html>