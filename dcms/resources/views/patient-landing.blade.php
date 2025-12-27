@extends('layouts.app')

@section('content')
<h2>Patient Information</h2>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/patient/landing">
    @csrf
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone"><br><br>

    <label>Birthdate:</label><br>
    <input type="date" name="birthdate"><br><br>

    <label>Gender:</label><br>
    <select name="gender">
        <option value="">Select</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Save Information</button>
</form>
@endsection
