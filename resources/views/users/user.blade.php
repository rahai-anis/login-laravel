@extends('layouts.app')

@section('title', 'user')

@section('content')
@if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
         @endif
<div class="container">
        <h1>Bienvenue, {{ auth()->user()->name }}</h1>
        <p>Ceci est votre tableau de bord utilisateur.</p>
    </div>
@endsection