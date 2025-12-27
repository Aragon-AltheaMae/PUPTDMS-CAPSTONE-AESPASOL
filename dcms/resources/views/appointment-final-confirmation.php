<!DOCTYPE html>
<html>
<head>
    <title>Appointment Final Confirmation</title>
</head>
<body>
    <h2>Final Confirmation</h2>

   <h3>Appointment Details</h3>
        <p>Patient: {{ $appointment->patient }}</p>
        <p>Date & Time: {{ $appointment->datetime }}</p>
        <p>Service: {{ $appointment->service }}</p>

        <h3>Dental History</h3>
        <ul>
        @foreach($appointment->dentalHistory as $dh)
            <li>{{ $dh->question }}: {{ $dh->answer }}</li>
        @endforeach
        </ul>

        <h3>Medical History</h3>
        <ul>
        @foreach($appointment->medicalHistory as $mh)
            <li>{{ $mh->question }}: {{ $mh->answer }}</li>
        @endforeach
        </ul>

    <p>Thank you! Your appointment request is complete.</p>
    <a href="/patient/dashboard">Back to Dashboard</a>
</body>
</html>
