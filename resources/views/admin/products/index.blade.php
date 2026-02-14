@extends('layouts.admin')

@section('title', 'Gestion des Produits')

@push('styles')
<style>
/* ====== HEADER ====== */
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
}
.admin-header h1 {
    font-size: 2rem;
    font-weight: 800;
}
.admin-header p {
    color: var(--text-secondary);
}

/* ====== STATS ====== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}
.stat-card {
    background: var(--dark-bg);
    border: 1px solid var(--dark-border);
    border-radius: 18px;
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
    align-items: center;
}
.stat-icon {
    width: 55px;
    height: 55px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    color: #fff;
}
.stat-info h3 {
    font-size: 1.6rem;
    font-weight: 800;
}
.stat-info p {
    font-size: 0.9rem;
    color: var(--text-secondary);
}

/* ====== PRODUCTS GRID ====== */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    padding: 1rem;
}

/* ====== PRODUCT CARD ====== */
.product-card {
    background: var(--dark-bg);
    border: 1px solid var(--dark-border);
    border-radius: 18px;
    overflow: hidden;
    transition: all 0.35s ease;
}
.product-card:hover {
    transform: translateY(-6px);
    border-color: var(--primary);
    box-shadow: 0 20px 40px rgba(0,0,0,.3);
}

/* IMAGE */
.product-image {
    position: relative;
    height: 190px;
    background: #0f122b;
}
.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* BADGES */
.badge {
    position: absolute;
    padding: .35rem .8rem;
    border-radius: 8px;
    font-size: .7rem;
    font-weight: 700;
}
.badge-type {
    top: .8rem;
    left: .8rem;
    background: #fff;
    color: var(--primary);
}
.badge-popular {
    top: .8rem;
    right: .8rem;
    background: var(--warning);
    color: #fff;
}
.badge-discount {
    bottom: .8rem;
    right: .8rem;
    background: var(--error);
    color: #fff;
}
.badge-inactive {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.75);
    display: flex;
    align-items: center;
    justify-content: center;
}
.badge-inactive span {
    background: var(--error);
    padding: .7rem 1.4rem;
    border-radius: 10px;
    font-weight: 800;
    color: #fff;
}

/* CONTENT */
.product-content {
    padding: 1.5rem;
}
.product-content h3 {
    font-size: 1.2rem;
    font-weight: 800;
    margin-bottom: .6rem;
}
.product-content p {
    font-size: .9rem;
    color: var(--text-secondary);
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* PRICE */
.product-price {
    display: flex;
    align-items: baseline;
    gap: .7rem;
    margin-bottom: 1rem;
}
.product-price strong {
    font-size: 1.7rem;
    color: var(--primary);
}
.product-price del {
    color: var(--text-secondary);
}

/* FOOTER */
.product-footer {
    display: flex;
    justify-content: space-between;
    padding-top: 1rem;
    border-top: 1px solid var(--dark-border);
    font-size: .85rem;
    color: var(--text-secondary);
}

/* ACTIONS */
.product-actions {
    display: flex;
    gap: .5rem;
    margin-top: 1.2rem;
}
.product-actions .btn {
    flex: 1;
    padding: .65rem;
    font-size: .85rem;
}
</style>
@endpush

@section('content')

<div class="admin-header">
    <div>
        <h1>Gestion des Produits</h1>
        <p>Administration complète de la boutique</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        ➕ Nouveau produit
    </a>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#667EEA,#764BA2)">📦</div>
        <div class="stat-info">
            <h3>{{ $stats['total'] }}</h3>
            <p>Total produits</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#00D4AA,#00B8A9)">✅</div>
        <div class="stat-info">
            <h3>{{ $stats['active'] }}</h3>
            <p>Produits actifs</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#FFB800,#FFA000)">⭐</div>
        <div class="stat-info">
            <h3>{{ $stats['popular'] }}</h3>
            <p>Populaires</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#00D4FF,#00A8E8)">💰</div>
        <div class="stat-info">
            <h3>{{ number_format($stats['revenue'],0,' ',' ') }} FCFA</h3>
            <p>Revenus</p>
        </div>
    </div>
</div>

{{-- LISTE PRODUITS --}}
<div class="card">
@if($products->count())
<div class="products-grid">
@foreach($products as $product)
<div class="product-card">

    {{-- IMAGE --}}
    <div class="product-image">
        {{-- <img src="{{ $product->image ? (Str::startsWith($product->image,'http') ? $product->image : asset('storage/'.$product->image)) : asset('images/placeholder.png') }}"
             alt="{{ $product->title }}"> --}}


        <img
            src="{{ route('products.image', basename($product->image)) }}"
            alt="{{ $product->title }}"
            style="width: 100%; height: 100%; object-fit: cover;"
        >

        <span class="badge badge-type">{{ $product->type }}</span>

        @if($product->is_popular)
            <span class="badge badge-popular">⭐ Populaire</span>
        @endif

        @if($product->discount_percentage)
            <span class="badge badge-discount">-{{ $product->discount_percentage }}%</span>
        @endif

        @unless($product->is_active)
            <div class="badge-inactive"><span>INACTIF</span></div>
        @endunless
    </div>

    {{-- CONTENT --}}
    <div class="product-content">
        <h3>{{ $product->title }}</h3>
        <p>{{ $product->description }}</p>

        <div class="product-price">
            <strong>{{ number_format($product->price,0,' ',' ') }} FCFA</strong>
            @if($product->old_price)
                <del>{{ number_format($product->old_price,0,' ',' ') }}</del>
            @endif
        </div>

        <div class="product-footer">
            <span>🛍 {{ $product->sales_count }} ventes</span>
            <span>{{ $product->created_at->format('d/m/Y') }}</span>
        </div>

        <div class="product-actions">
            <a href="{{ route('product.show',$product->slug) }}" target="_blank" class="btn btn-secondary">👁 Voire</a>
            <a href="{{ route('admin.products.edit',$product->id) }}" class="btn btn-secondary">✏️ Modifier</a>
            <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST"
                  onsubmit="return confirm('Supprimer ce produit ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger">🗑 Supprimer</button>
            </form>
        </div>
    </div>

</div>
@endforeach
</div>

<div style="padding:2rem">{{ $products->links() }}</div>
@else
<div style="text-align:center;padding:5rem">
    <h3>Aucun produit</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">Créer un produit</a>
</div>
@endif
</div>

@endsection
