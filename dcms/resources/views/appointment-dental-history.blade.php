<!DOCTYPE html>
<html>
<head>
    <title>Dental History Survey</title>
</head>
<body>
    <h2>Dental History Survey</h2>
    <form method="POST" action="{{ url('/patient/appointment/dental-history') }}">
        @csrf
        <label><input type="checkbox" name="question1" value="Yes"> Do you experience tooth sensitivity?</label><br>
        <label><input type="checkbox" name="question2" value="Yes"> Do you brush twice a day?</label><br>
        <label><input type="checkbox" name="question3" value="Yes"> Do you floss regularly?</label><br>
        <label><input type="checkbox" name="question4" value="Yes"> Have you had any tooth extractions?</label><br>
        <label><input type="checkbox" name="question5" value="Yes"> Have you experienced gum bleeding?</label><br>
        <button type="submit">Next</button>
    </form>
</body>
</html>
