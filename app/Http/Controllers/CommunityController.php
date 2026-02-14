<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use App\Models\BlogPost;
// use App\Models\Event;

// class CommunityController extends Controller
// {
//     public function index()
//     {
//         // Récupérer les membres actifs (utilisateurs avec au moins un article publié ou un événement)
//         $activeMembers = User::where('role', '!=', 'admin')
//             ->withCount(['blogPosts as posts_count' => function($query) {
//                 $query->where('is_published', true);
//             }])
//             ->having('posts_count', '>', 0)
//             ->orderBy('posts_count', 'desc')
//             ->limit(12)
//             ->get();

//         // Récupérer tous les membres
//         $allMembers = User::where('role', '!=', 'admin')
//             ->latest()
//             ->paginate(16);

//         // Événements à venir pour la communauté
//         $upcomingEvents = Event::where('event_date', '>=', now())
//             ->orderBy('event_date', 'asc')
//             ->limit(3)
//             ->get();

//         // Articles récents de la communauté
//         $recentPosts = BlogPost::where('is_published', true)
//             ->with('author')
//             ->latest('published_at')
//             ->limit(6)
//             ->get();

//         // Statistiques de la communauté
//         $stats = [
//             'total_members' => User::where('role', '!=', 'admin')->count(),
//             'total_posts' => BlogPost::where('is_published', true)->count(),
//             'total_events' => Event::count(),
//             'active_this_month' => User::where('created_at', '>=', now()->subMonth())->count(),
//         ];

//         return view('public.community.index', compact(
//             'activeMembers',
//             'allMembers',
//             'upcomingEvents',
//             'recentPosts',
//             'stats'
//         ));
//     }
// }




// <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\Event;
use App\Models\CommunityGroup;
use App\Models\CommunityPost;
use App\Models\CommunityReply;

class CommunityController extends Controller
{
    /**
     * Page d'accueil de la communauté
     */
    public function index()
    {
        // Récupérer les membres actifs
        $activeMembers = User::where('role', '!=', 'admin')
            ->withCount('blogPosts')
            ->orderBy('blog_posts_count', 'desc')
            ->limit(12)
            ->get();

        // Tous les groupes
        $groups = CommunityGroup::withCount(['posts', 'members'])
            ->orderBy('posts_count', 'desc')
            ->get();

        // Discussions récentes
        $recentPosts = CommunityPost::with(['author', 'group'])
            ->withCount('replies')
            ->latest()
            ->limit(10)
            ->get();

        // Événements à venir
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->limit(3)
            ->get();

        // Statistiques de la communauté
        $stats = [
            'total_members' => User::where('role', '!=', 'admin')->count(),
            'total_posts' => CommunityPost::count(),
            'total_groups' => CommunityGroup::count(),
            'active_this_month' => User::where('created_at', '>=', now()->subMonth())->count(),
        ];

        return view('public.community.index', compact(
            'activeMembers',
            'groups',
            'recentPosts',
            'upcomingEvents',
            'stats'
        ));
    }

    /**
     * Afficher un groupe spécifique
     */
    public function showGroup(CommunityGroup $group)
    {
        // Charger les posts du groupe avec pagination
        $posts = $group->posts()
            ->with(['author', 'replies.author'])
            ->withCount('replies')
            ->latest()
            ->paginate(15);

        // Membres du groupe
        $members = $group->members()->limit(20)->get();
        $membersCount = $group->members()->count();

        // Vérifier si l'utilisateur est membre du groupe
        $isMember = auth()->check() && $group->members()->where('user_id', auth()->id())->exists();

        return view('public.community.group', compact('group', 'posts', 'members', 'membersCount', 'isMember'));
    }

    /**
     * Créer un nouveau post dans un groupe
     */
    public function createPost(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour poster.');
        }

        $validated = $request->validate([
            'group_id' => 'required|exists:community_groups,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = CommunityPost::create([
            'group_id' => $validated['group_id'],
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('community.group', $post->group->slug)
            ->with('success', 'Votre discussion a été publiée !');
    }

    /**
     * Créer une réponse à un post
     */
    public function createReply(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour répondre.');
        }

        $validated = $request->validate([
            'post_id' => 'required|exists:community_posts,id',
            'content' => 'required|string',
        ]);

        $reply = CommunityReply::create([
            'post_id' => $validated['post_id'],
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        $post = CommunityPost::find($validated['post_id']);

        return redirect()->route('community.group', $post->group->slug)
            ->with('success', 'Votre réponse a été publiée !');
    }

    /**
     * Rejoindre un groupe
     */
    public function joinGroup(CommunityGroup $group)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour rejoindre un groupe.');
        }

        // Vérifier si l'utilisateur est déjà membre
        if ($group->members()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()->with('info', 'Vous êtes déjà membre de ce groupe.');
        }

        // Ajouter l'utilisateur au groupe
        $group->members()->attach(auth()->id());

        return redirect()->back()->with('success', 'Vous avez rejoint le groupe avec succès !');
    }

    /**
     * Quitter un groupe
     */
    public function leaveGroup(CommunityGroup $group)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $group->members()->detach(auth()->id());

        return redirect()->back()->with('success', 'Vous avez quitté le groupe.');
    }
}
