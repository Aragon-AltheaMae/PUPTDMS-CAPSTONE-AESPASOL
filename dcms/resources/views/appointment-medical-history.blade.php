<!DOCTYPE html>
<html>
<head>
    <title>Medical History Survey</title>
</head>
<body>
    <h2>Medical History Survey</h2>
    <form method="POST" action="{{ url('/patient/appointment/medical-history') }}">
        @csrf
        <label><input type="checkbox" name="allergies" value="Yes"> Do you have any allergies?</label><br>
        <label><input type="checkbox" name="heart_condition" value="Yes"> Do you have a heart condition?</label><br>
        <label><input type="checkbox" name="diabetes" value="Yes"> Do you have diabetes?</label><br>
        <label><input type="checkbox" name="pregnant" value="Yes"> Are you currently pregnant?</label><br>
        <label><input type="checkbox" name="other_conditions" value="Yes"> Any other medical conditions?</label><br>
        <button type="submit">Next</button>
    </form>
</body>
</html>
