<!DOCTYPE html>
<html>
<head>
    <title>Select Date & Time</title>
</head>
<body>
    <h2>Select Appointment Date & Time</h2>
    <form method="POST" action="{{ url('/patient/appointment/calendar') }}">
        @csrf
        <label>Date & Time:</label>
        <input type="datetime-local" name="date_time" required>
        <button type="submit">Next</button>
    </form>
</body>
</html>
