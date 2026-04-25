<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        /* BACKGROUND */

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CONTAINER */

        .container {
            display: flex;
            width: 900px;
            height: 520px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* LEFT IMAGE SIDE */

        .left {
            width: 50%;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left img {
            width: 80%;
        }

        /* RIGHT SIDE */

        .right {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
        }

        /* TEXT */

        .right h1 {
            font-size: 30px;
            margin-bottom: 10px;
            color: #333;
        }

        .right p {
            font-size: 15px;
            margin-bottom: 25px;
            color: #666;
        }

        /* FORM */

        .right h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 15px;
            transition: .3s;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.08);
        }

        input:focus {
            border-color: #667eea;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            outline: none;
        }

        /* BUTTON */

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        /* LINK */

        .link {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
            justify-content: center;
        }

        .link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- LEFT IMAGE -->

        <div class="left">
            <img src="https://img.freepik.com/free-vector/job-interview-concept-illustration_114360-24598.jpg">
        </div>

        <!-- RIGHT SIDE -->

        <div class="right">

            <h1>Choose Your Career </h1>
            <p>Find internships and connect with top companies to start your professional journey.</p>

            <h2>Login</h2>

            @if(session('error'))
            <p class="error">{{ session('error') }}</p>
            @endif

            <form method="POST" action="/login">
                @csrf

                <div class="input-group">
                    <input type="email" name="email" placeholder="Email">
                </div>

                <div class="input-group">
                    <input type="password" name="password" placeholder="Password">
                </div>

                <button type="submit">Login</button>

            </form>

            <div class="link">
                <a href="/register">Create Account</a>
            </div>

        </div>

    </div>

</body>

</html>