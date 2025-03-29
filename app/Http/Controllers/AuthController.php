<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if(! $user) {
            return back()->withErrors([
                'email' => 'Email incorrects.',
            ]);
        }
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'Password incorrects.',
            ]);
        }
    
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Votre compte est désactivé. Veuillez contacter l\'administrateur.',
            ]);
        }
    
        $request->session()->regenerate();
        
        return $user->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('user.dashboard');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validation des champs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ], [
            'password.confirmed' => 'Le mot de passe et la confirmation ne correspondent pas.'
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', 
            'is_active' => true,
        ]);

        // Connexion automatique après inscription
        Auth::login($user);

        // Redirection vers le tableau de bord
        return redirect()->route('user.dashboard')->with('success', 'Inscription réussie !');
    }
}
