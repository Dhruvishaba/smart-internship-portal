<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(120deg, #89f7fe, #66a6ff);
            font-family: Arial, sans-serif;
        }

        .container {
            width: 380px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            animation: slideIn 1s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: 0.3s;
        }

        input:focus, select:focus {
            border-color: #66a6ff;
            box-shadow: 0 0 5px rgba(102,166,255,0.5);
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            background: #66a6ff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #4f8df5;
            transform: scale(1.05);
        }

        .footer {
            text-align: center;
            margin-top: 15px;
        }

        a {
            text-decoration: none;
            color: #66a6ff;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Account</h2>

    <form method="POST" action="/register">
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
        <a href="/login">Already have an account?</a>
    </div>
</div>

</body>
</html>