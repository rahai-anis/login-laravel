<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}
    public function userDashboard()
    {
        return view('users.user');
    }

    public function adminDashboard()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Impossible de supprimer un administrateur.');
        }
    
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur supprimé avec succès.');
    }

    // Activer/Désactiver un utilisateur
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard')->with('error', 'Impossible de désactiver un administrateur.');
    }

    $user->is_active = !$user->is_active;
    $user->save();

    return redirect()->route('admin.dashboard')->with('success', 'Statut de l’utilisateur mis à jour.');
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'nullable|min:6|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password) ;
    }

    $user->save();

    return redirect()->route('admin.dashboard')->with('success', 'Utilisateur mis à jour.');
}

}
