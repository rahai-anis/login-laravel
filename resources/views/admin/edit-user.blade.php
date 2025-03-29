@extends('layouts.app')

@section('title', 'Modifier les utilisateurs')

@section('content')
<h1 class="mb-4">Modifier l'utilisateur</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.users.update', $user->id) }}" method="post">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <div class="mb-3">
            <label class="form-label">Nouveau Mot de Passe (optionnel)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmer le Mot de Passe</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Annuler</a>
</form>

@endsection