<?php

namespace App\Http\Controllers;

use App\Models\Realisation;
use Illuminate\Http\Request;

class RealisationController extends Controller
{
    public function index(Request $request)
    {
        $query = Realisation::query();

        // Filtrer par catégorie si spécifié
        if ($request->has('category') && $request->category != 'all') {
            $query->byCategory($request->category);
        }

        $realisations = $query->latest()->paginate(9);

        $categories = ['all', 'web', 'mobile', 'design'];

        return view('public.realisations.index', compact('realisations', 'categories'));
    }

    public function show($slug)
    {
        $realisation = Realisation::where('slug', $slug)->firstOrFail();

        // Récupérer les projets similaires
        $similarRealisations = Realisation::where('category', $realisation->category)
            ->where('id', '!=', $realisation->id)
            ->take(3)
            ->get();

        return view('public.realisations.show', compact('realisation', 'similarRealisations'));
    }
}
