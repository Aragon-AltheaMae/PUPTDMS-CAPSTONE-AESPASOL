<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration</title>
</head>
<body>
    <h1>Create Your Account</h1>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success Message --}}
    @if (session('success'))
        <div style="color:green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        {{-- STUDENT NUMBER (REQUIRED) --}}
        <label>Student Number:</label><br>
        <input
            type="text"
            name="student_number"
            value="{{ old('student_number') }}"
            required
        >
        <br><br>

        {{-- NAME --}}
        <label>Full Name:</label><br>
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
        >
        <br><br>

        {{-- EMAIL --}}
        <label>Email:</label><br>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
        >
        <br><br>

        {{-- PHONE --}}
        <label>Phone:</label><br>
        <input
            type="text"
            name="phone"
            value="{{ old('phone') }}"
        >
        <br><br>

        {{-- BIRTHDATE --}}
        <label>Birthdate:</label><br>
        <input
            type="date"
            name="birthdate"
            value="{{ old('birthdate') }}"
            required
        >
        <br><br>

        {{-- GENDER --}}
        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="">Select</option>
            <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
            <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
        </select>
        <br><br>

        {{-- PASSWORD --}}
        <label>Password:</label><br>
        <input type="password" name="password" required>
        <br><br>

        {{-- CONFIRM PASSWORD --}}
        <label>Confirm Password:</label><br>
        <input type="password" name="password_confirmation" required>
        <br><br>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="/login">Login here</a></p>
</body>
</html>
