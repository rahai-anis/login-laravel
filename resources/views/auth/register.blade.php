<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow" style="width: 400px;">
    <h3 class="text-center">Inscription</h3>
    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Nom" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
    </form>
    <div class="mt-3 text-center">
        <p>Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous ici</a></p>
    </div>
</div>

</body>
</html>
