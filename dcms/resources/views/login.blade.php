<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    @if (session('error'))
        <div style="color:red;">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div style="color:green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <label>Email / Username:</label><br>
        <input type="text" name="username" value="{{ old('username') }}" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="/register">Register here</a></p>
</body>
</html>
