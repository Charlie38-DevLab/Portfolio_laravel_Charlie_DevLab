<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\EventRegistration;
use App\Models\UserActivity;

class ProfileController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();

        // Récupérer les statistiques
        $totalPurchases = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $totalEvents = EventRegistration::where('user_id', $user->id)
            ->count();

        $totalForumPosts = 0; // À implémenter plus tard si vous avez le forum

        // Récupérer les activités récentes
        $recentActivities = UserActivity::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Récupérer les achats
        $purchases = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('product')
            ->latest()
            ->take(5)
            ->get();

        // Récupérer les événements inscrits
        $events = EventRegistration::where('user_id', $user->id)
            ->with('event')
            ->latest()
            ->take(5)
            ->get();

        // Récupérer les groupes rejoints (si vous avez la communauté)
        $groups = collect(); // Vide pour l'instant

        return view('profile.index', compact(
            'user',
            'totalPurchases',
            'totalEvents',
            'totalForumPosts',
            'recentActivities',
            'purchases',
            'events',
            'groups'
        ));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Mettre à jour le profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'avatar.image' => 'Le fichier doit être une image.',
            'avatar.mimes' => 'L\'image doit être au format: jpeg, png, jpg ou gif.',
            'avatar.max' => 'L\'image ne doit pas dépasser 2MB.',
            'current_password.required_with' => 'Le mot de passe actuel est requis pour changer de mot de passe.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'new_password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        try {
            // Mise à jour du nom et email
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            // Mise à jour de l'avatar si fourni
            if ($request->hasFile('avatar')) {
                // Supprimer l'ancien avatar s'il existe
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Stocker le nouvel avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            // Mise à jour du mot de passe si fourni
            if ($request->filled('new_password')) {
                // Vérifier le mot de passe actuel
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()
                        ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])
                        ->withInput();
                }

                // Mettre à jour le mot de passe
                $user->password = Hash::make($request->new_password);
            }

            // Sauvegarder les modifications
            // $user->save();

            // Enregistrer l'activité
            if (class_exists(UserActivity::class)) {
                UserActivity::create([
                    'user_id' => $user->id,
                    'activity_type' => 'profile_update',
                    'title' => 'Profil mis à jour',
                    'description' => 'Vous avez mis à jour votre profil',
                    'icon' => '✏️',
                ]);
            }

            return redirect()
                ->route('profile.index')
                ->with('success', 'Profil mis à jour avec succès !');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du profil.')
                ->withInput();
        }
    }

    /**
     * Afficher mes événements
     */
    public function myEvents()
    {
        $user = Auth::user();

        $events = EventRegistration::where('user_id', $user->id)
            ->with('event')
            ->latest()
            ->paginate(12);

        return view('profile.events', compact('events'));
    }

    /**
     * Afficher mes achats
     */
    public function myPurchases()
    {
        $user = Auth::user();

        $purchases = Order::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->paginate(12);

        return view('profile.purchases', compact('purchases'));
    }

    /**
     * Supprimer une activité spécifique
     */
    public function deleteActivity($id)
    {
        try {
            $user = Auth::user();

            // Trouver l'activité et vérifier qu'elle appartient à l'utilisateur
            $activity = UserActivity::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$activity) {
                return redirect()
                    ->route('profile.index')
                    ->with('error', 'Activité introuvable.');
            }

            // Supprimer l'activité
            $activity->delete();

            return redirect()
                ->route('profile.index')
                ->with('success', 'Activité supprimée avec succès !');

        } catch (\Exception $e) {
            return redirect()
                ->route('profile.index')
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * Supprimer toutes les activités de l'utilisateur
     */
    public function clearAllActivities()
    {
        try {
            $user = Auth::user();

            // Supprimer toutes les activités de l'utilisateur
            $deletedCount = UserActivity::where('user_id', $user->id)->delete();

            return redirect()
                ->route('profile.index')
                ->with('success', $deletedCount . ' activité(s) supprimée(s) avec succès !');

        } catch (\Exception $e) {
            return redirect()
                ->route('profile.index')
                ->with('error', 'Une erreur est survenue lors de la suppression des activités.');
        }
    }
}
