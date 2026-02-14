<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Liste des articles du blog (public)
     */
    public function index(Request $request)
    {
        $query = BlogPost::published()->with('author');

        // Filtre par catégorie
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        $posts = $query
            ->orderBy('published_at', 'desc')
            ->paginate(9)
            ->withQueryString();

        // Catégories (uniques)
        $categories = BlogPost::published()
            ->select('category')
            ->distinct()
            ->pluck('category');

        // Articles populaires
        $popularPosts = BlogPost::published()
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return view('public.blog.index', compact(
            'posts',
            'categories',
            'popularPosts'
        ));
    }

    /**
     * Détail d’un article
     */
    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->with('author')
            ->where('slug', $slug)
            ->firstOrFail();

        // Incrémenter les vues
        $post->incrementViews();

        // Articles similaires
        $relatedPosts = BlogPost::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('public.blog.show', compact(
            'post',
            'relatedPosts'
        ));
    }
}
