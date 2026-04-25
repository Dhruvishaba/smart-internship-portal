<!DOCTYPE html>
<html>

<head>
    <title>Register</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            width: 900px;
            height: 540px;
            background: white;
            border-radius: 15px;
            overflow: hidden;

        }

        .left {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
        }

        .left img {
            width: 100%;
        }

        .right {
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }

        .right p {
            font-size: 14px;
            margin-bottom: 20px;
            color: #666;
        }

        .right h2 {
            font-size: 22px;
            margin-bottom: 15px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: .3s;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.08);
        }

        input:focus,
        select:focus {
            border-color: #667eea;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .footer {
            margin-top: 12px;
            font-size: 14px;
            text-align: center;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .alert {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 14px;
        }

        .error {
            background: #ffdddd;
            color: #d8000c;
        }

        .success {
            background: #ddffdd;
            color: #4f8a10;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="left">
            <img src="https://img.freepik.com/free-vector/sign-up-concept-illustration_114360-7965.jpg">
        </div>

        <div class="right">

            <h1>Start Your Career</h1>
            <p>Create an account and explore internship opportunities.</p>

            <h2>Create Account</h2>

            @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert error">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <input type="text" name="name" placeholder="Full Name" required>

                <input type="email" name="email" placeholder="Email" required>

                <input type="password" name="password" placeholder="Password" required>

                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <option value="company">Company</option>
                </select>

                <button type="submit">Register</button>

            </form>

            <div class="footer">
                <a href="{{ route('login') }}">Already have an account?</a>
            </div>

        </div>

    </div>

</body>

</html>