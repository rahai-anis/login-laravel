@extends('layouts.app')

@section('title', 'Liste des utilisateurs')

@section('content')
        <h1 class="text-center mb-4">Liste des utilisateurs</h1>
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
         @endif
         @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
         @endif
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td>
                        <!-- Modifier -->
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                        <!-- Activer/Désactiver -->
                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>

                        <!-- Supprimer -->
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
 @endsection