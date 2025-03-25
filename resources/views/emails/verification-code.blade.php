<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikacioni kod</title>
</head>
<body>
    <h2>Zdravo, {{ $user->first_name }}!</h2>
    <p>Hvala što si se registrovao.</p>
    <p>Tvoj verifikacioni kod je:</p>
    <h1>{{ $code }}</h1>
    <p>Unesi ovaj kod u aplikaciji da verifikuješ svoj nalog.</p>
    <br>
    <p>Srdačno,<br>Vaš tim</p>
</body>
</html>
