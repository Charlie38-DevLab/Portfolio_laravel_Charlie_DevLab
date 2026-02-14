<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));



        //         $query = User::query();

        // if ($request->filled('search')) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('name', 'like', '%' . $request->search . '%')
        //           ->orWhere('email', 'like', '%' . $request->search . '%');
        //     });
        // }

        // if ($request->filled('role')) {
        //     $query->where('role', $request->role);
        // }

        // return view('admin.users.index', [
        //     'users'        => $query->latest()->paginate(10)->withQueryString(),
        //     'totalUsers'   => User::count(),
        //     'adminsCount'  => User::where('role', 'admin')->count(),
        //     'usersCount'   => User::where('role', 'user')->count(),
        //     'todayCount'   => User::whereDate('created_at', today())->count(),
        // ]);
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Mettre à jour les données
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Mettre à jour le mot de passe si fourni
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès !');
    }

    /**
     * Supprimer un utilisateur
     *
     * @param User $user
     */
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === Auth::id()) { // ✅ Plus de soulignement rouge après ajout PHPDoc
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte !');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "L'utilisateur {$userName} a été supprimé avec succès !");
    }
}
