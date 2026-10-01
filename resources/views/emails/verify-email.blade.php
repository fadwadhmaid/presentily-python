<!-- resources/views/emails/verify-email.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vérification d'email</title>
</head>
<body>
    <h1>Bonjour {{ $user->name }} !</h1>
    <p>Merci de vous être inscrit sur Presentily.</p>
    <p>Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :</p>
    <a href="{{ $frontend_url }}/verify-email/{{ $token }}">
        Vérifier mon email
    </a>
    <p>Ce lien expirera dans 24 heures.</p>
    <p>Si vous n'avez pas créé de compte, ignorez cet email.</p>
    <p>L'équipe Presentily</p>
</body>
</html>