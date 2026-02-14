<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Afficher la liste des produits
     */
    public function index()
    {
        $products = Product::latest()->paginate(15);

        $stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'popular' => Product::where('is_popular', true)->count(),
            'total_sales' => Product::sum('sales_count'),
            'revenue' => Product::sum('price') * Product::sum('sales_count'),
        ];

        return view('admin.products.index', compact('products', 'stats'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Enregistrer un nouveau produit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:ebook,formation,service,template,coaching,cv/portfolio',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'features' => 'required|string',
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'type.required' => 'Le type de produit est obligatoire.',
            'price.required' => 'Le prix est obligatoire.',
            'image.required' => 'L\'image est obligatoire.',
            'features.required' => 'Les caractéristiques sont obligatoires.',
        ]);

        try {
            // Upload de l'image
            $imagePath = $request->file('image')->store('products', 'public');

            // Conversion des features en tableau
            $features = array_map('trim', explode("\n", $validated['features']));
            $features = array_filter($features); // Enlever les lignes vides

            // Calculer la réduction si old_price existe
            $discountPercentage = null;
            if ($validated['old_price'] && $validated['old_price'] > $validated['price']) {
                $discountPercentage = round((($validated['old_price'] - $validated['price']) / $validated['old_price']) * 100);
            }

            // Créer le produit
            Product::create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . uniqid(),
                'description' => $validated['description'],
                'type' => $validated['type'],
                'price' => $validated['price'],
                'old_price' => $validated['old_price'] ?? null,
                'discount_percentage' => $discountPercentage,
                'image' => $imagePath,
                'features' => $features,
                'sales_count' => 0,
                'is_popular' => $request->has('is_popular'),
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produit créé avec succès ! ✅');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Mettre à jour un produit
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:ebook,formation,service,template,coaching,cv/portfolio',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'features' => 'required|string',
        ]);

        try {
            // Upload de la nouvelle image si fournie
            $imagePath = $product->image;
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('products', 'public');
            }

            // Conversion des features
            $features = array_map('trim', explode("\n", $validated['features']));
            $features = array_filter($features);

            // Calculer la réduction
            $discountPercentage = null;
            if ($validated['old_price'] && $validated['old_price'] > $validated['price']) {
                $discountPercentage = round((($validated['old_price'] - $validated['price']) / $validated['old_price']) * 100);
            }

            // Mettre à jour le produit
            $product->update([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . $product->id,
                'description' => $validated['description'],
                'type' => $validated['type'],
                'price' => $validated['price'],
                'old_price' => $validated['old_price'] ?? null,
                'discount_percentage' => $discountPercentage,
                'image' => $imagePath,
                'features' => $features,
                'is_popular' => $request->has('is_popular'),
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()
                ->route('admin.products.edit', $product->id)
                ->with('success', 'Produit mis à jour avec succès ! ✅');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un produit
     */
    public function destroy(Product $product)
    {
        try {
            // Supprimer l'image associée
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $title = $product->title;
            $product->delete();

            return redirect()
                ->route('admin.products.index')
                ->with('success', "Produit '{$title}' supprimé avec succès ! 🗑️");

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression.');
        }
    }
}
