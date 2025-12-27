<!DOCTYPE html>
<html>
<head>
    <title>Select Service</title>
</head>
<body>
    <h2>Select Dental Service</h2>
    <form method="POST" action="{{ url('/patient/appointment/services') }}">
        @csrf
        <select name="service" required>
            <option value="Oral Check-Up">Oral Check-Up</option>
            <option value="Dental Cleaning">Dental Cleaning</option>
            <option value="Dental Restoration & Prosthesis">Dental Restoration & Prosthesis</option>
            <option value="Dental Surgery">Dental Surgery</option>
        </select>
        <button type="submit">Next</button>
    </form>
</body>
</html>
