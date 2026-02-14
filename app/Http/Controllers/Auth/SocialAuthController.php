<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Rediriger l'utilisateur vers le provider OAuth
     */
    public function redirectToProvider($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Erreur lors de la connexion avec ' . ucfirst($provider));
        }
    }

    /**
     * Gérer le callback du provider OAuth
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Déterminer le champ ID selon le provider
            $providerIdField = $provider . '_id';

            // Chercher l'utilisateur par provider ID
            $user = User::where($providerIdField, $socialUser->getId())->first();

            // Si l'utilisateur n'existe pas, vérifier par email
            if (!$user) {
                $user = User::where('email', $socialUser->getEmail())->first();

                if ($user) {
                    // Lier le compte OAuth à l'utilisateur existant
                    $user->update([
                        $providerIdField => $socialUser->getId(),
                        'avatar' => $user->avatar ?? $socialUser->getAvatar(),
                    ]);
                } else {
                    // Créer un nouvel utilisateur
                    $user = User::create([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        $providerIdField => $socialUser->getId(),
                        'avatar' => $socialUser->getAvatar(),
                        'role' => 'user',
                        'email_verified_at' => now(),
                    ]);
                }
            }

            // Connecter l'utilisateur
            Auth::login($user, true);

            return redirect()->route('home')
                ->with('success', 'Connexion réussie avec ' . ucfirst($provider) . ' !');

        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Erreur lors de la connexion avec ' . ucfirst($provider) . '. Veuillez réessayer.');
        }
    }
}
