<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(-45deg, #667eea, #764ba2, #6b8cff, #8e44ad);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
            font-family: Arial, sans-serif;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            width: 320px;
            padding: 40px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            text-align: center;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .input-group {
            position: relative;
            margin: 20px 0;
        }

        input {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 2px solid #ccc;
            outline: none;
            font-size: 14px;
            transition: 0.3s;
        }

        input:focus {
            border-bottom: 2px solid #667eea;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            background: #667eea;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #5a67d8;
            transform: scale(1.05);
        }

        a {
            text-decoration: none;
            font-size: 14px;
            color: #667eea;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Login</h2>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="input-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <br>
    <a href="/register">Create Account</a>
</div>

</body>
</html>