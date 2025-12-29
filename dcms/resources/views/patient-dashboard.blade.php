<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        section { margin-top: 30px; }
        input, select { display: block; margin: 10px 0; padding: 8px; width: 300px; }
        button { padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer; }
        table { border-collapse: collapse; width: 90%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .success { color: green; }
        .logout { margin-top: 10px; display: inline-block; }
    </style>
</head>
<body>
    <h1>Welcome, {{ $patient->name }}</h1>

    <!-- Logout -->
    <a class="logout" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" method="POST" action="/logout">@csrf</form>

    <!-- Appointment Section -->
    <section>
        <a href="{{ url('/patient/appointment/calendar') }}">
            <button type="button">Set Appointment</button>
        </a>
    </section>

    <!-- Dental Records Section -->
    <section>
        <h2>Dental Records</h2>
        @if(!empty($dentalRecords))
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Dentist</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dentalRecords as $record)
                        <tr>
                            <td>{{ $record['date'] }}</td>
                            <td>{{ $record['dentist'] }}</td>
                            <td>{{ $record['notes'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No dental records available.</p>
        @endif
    </section>

    <!-- Request Dental Clearance -->
    <section>
        <h2>Request Dental Clearance</h2>
        @if(session('success_clearance'))
            <p class="success">{{ session('success_clearance') }}</p>
        @endif
        <form method="POST" action="{{ url('/patient/request-clearance') }}">
            @csrf
            <button type="submit">Request Clearance</button>
        </form>
    </section>

    <!-- Request Dental Health Record -->
    <section>
        <h2>Request Dental Health Record</h2>
        @if(session('success_health'))
            <p class="success">{{ session('success_health') }}</p>
        @endif
        <form method="POST" action="{{ url('/patient/request-health-record') }}">
            @csrf
            <button type="submit">Request Health Record</button>
        </form>
    </section>
</body>
</html>
