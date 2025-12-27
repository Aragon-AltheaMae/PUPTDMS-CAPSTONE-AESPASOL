<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-container { padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        input { display: block; margin: 10px 0; padding: 8px; width: 100%; }
        button { padding: 10px; width: 100%; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
