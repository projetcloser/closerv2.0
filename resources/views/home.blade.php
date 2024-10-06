<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
<h1>{{ $message ?? 'Bienvenue' }}</h1>
<a href="{{ route('logout') }}">Se déconnecter</a>
</body>
</html>
