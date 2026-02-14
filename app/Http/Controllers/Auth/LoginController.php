<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Gérer la connexion
     */
    public function login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // 🔍 DEBUG : Vérifier si l'utilisateur existe
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::warning("Tentative de connexion avec email inexistant: {$email}");

            return redirect()->back()
                ->withErrors([
                    'email' => 'Aucun compte trouvé avec cet email.',
                ])
                ->withInput($request->only('email'));
        }

        // 🔍 DEBUG : Vérifier le mot de passe
        if (!Hash::check($request->password, $user->password)) {
            Log::warning("Mot de passe incorrect pour: {$email}");

            return redirect()->back()
                ->withErrors([
                    'email' => 'Le mot de passe est incorrect.',
                ])
                ->withInput($request->only('email'));
        }

        // Tentative de connexion
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            Log::info("Connexion réussie pour: {$user->email} (Rôle: {$user->role})");

            // Redirection selon le rôle
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Bienvenue Admin ' . $user->name . ' !');
            }

            // Utilisateur normal
            return redirect()->intended(route('home'))
                ->with('success', 'Bienvenue ' . $user->name . ' !');
        }

        // Échec de connexion (ne devrait normalement pas arriver ici)
        Log::error("Échec de connexion inexpliqué pour: {$email}");

        // return redirect()->back()
        //     ->withErrors([
        //         'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        //     ])
        //     ->withInput($request->only('email'));
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->name;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'À bientôt ' . $userName . ' !');
    }

    /**
     * 🔧 MÉTHODE DE DEBUG (À SUPPRIMER EN PRODUCTION)
     * Accéder via : /debug-admin-login
     */
    public function debugAdminLogin()
    {
        if (!app()->environment('local')) {
            abort(404);
        }

        $admin = User::where('email', 'admin@charliedevlab.com')->first();

        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin non trouvé dans la base de données',
                'solution' => 'Exécutez: php artisan admin:create',
            ]);
        }

        $testPassword = 'Admin@2025';
        $passwordMatch = Hash::check($testPassword, $admin->password);

        return response()->json([
            'status' => 'success',
            'admin_exists' => true,
            'admin_data' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => $admin->role,
                'email_verified' => $admin->email_verified_at ? true : false,
            ],
            'password_test' => [
                'tested_password' => $testPassword,
                'match' => $passwordMatch,
                'message' => $passwordMatch
                    ? '✅ Le mot de passe correspond !'
                    : '❌ Le mot de passe ne correspond pas. Recréez le compte.',
            ],
        ]);
    }
}
