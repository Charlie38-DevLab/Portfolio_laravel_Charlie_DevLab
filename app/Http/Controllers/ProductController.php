<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active();

        // Filtrer par type si spécifié
        if ($request->has('type') && $request->type != 'all') {
            $query->byType($request->type);
        }

        // Trier
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('sales_count', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);

        $types = ['all', 'ebook', 'formation', 'service', 'template', 'coaching', 'cv/portfolio'];

        return view('public.product.index', compact('products', 'types'));
    }

    public function show($slug)
    {
        $product = Product::active()->where('slug', $slug)->firstOrFail();

        // Récupérer les produits similaires
        $similarProducts = Product::active()
            ->where('type', $product->type)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('public.product.show', compact('product', 'similarProducts'));
    }
}
