<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin:0;
            font-family: Arial, sans-serif;
            background:#f4f6f9;
        }

        .navbar {
            background:#2c3e50;
            padding:15px;
            color:white;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .navbar a {
            color:white;
            text-decoration:none;
            margin-left:15px;
        }

        .container {
            padding:30px;
        }

        input, select, textarea {
            width:100%;
            padding:8px;
            margin-top:5px;
            border:1px solid #ccc;
            border-radius:5px;
        }

        textarea {
            min-height:80px;
        }

        button {
            cursor:pointer;
        }
    </style>
</head>
<body>


<div class="navbar">
    <div>
        <strong">Smart Internship and Skill Recommendation System</strong>
    </div>

    <div>

        {{-- STUDENT NAVBAR --}}
        @if(Auth::user()->role == 'student')

            <a href="{{ route('student.dashboard') }}">Dashboard</a>
            <a href="{{ route('student.profile') }}">Profile</a>

        @endif


        {{-- COMPANY NAVBAR --}}
        @if(Auth::user()->role == 'company')

            <a href="{{ route('company.dashboard') }}">Dashboard</a>
            

        @endif


        <!-- <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;color:white;">
                Logout
            </button>
        </form> -->

    </div>
</div>



<div class="container">
    @yield('content')
</div>

</body>
</html>