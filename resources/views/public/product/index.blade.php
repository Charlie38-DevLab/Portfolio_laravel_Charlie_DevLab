@extends('layouts.app_layout')

@section('title', 'Boutique - Charlie DevLab')

@push('styles')
<style>
    .page-header {
        padding: 8rem 2rem 4rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 20% 50%, rgba(108, 92, 231, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(0, 184, 169, 0.15) 0%, transparent 50%);
        animation: gradient-shift 15s ease infinite;
        background-size: 200% 200%;
    }

    .page-header-content {
        max-width: 1400px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .page-subtitle {
        font-size: 0.9rem;
        color: var(--primary-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 1rem;
    }

    .page-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-description {
        font-size: 1.2rem;
        color: var(--text-secondary);
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.8;
    }

    .filters-section {
        padding: 2rem;
        background: var(--dark-card);
        border-bottom: 1px solid var(--dark-border);
        position: sticky;
        top: 80px;
        z-index: 100;
    }

    .filters-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        gap: 1.5rem;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.8rem 1.5rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .filter-btn:hover,
    .filter-btn.active {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        color: var(--primary);
    }

    .filter-btn.active {
        background: var(--primary);
        color: white;
    }

    .products-section {
        padding: 4rem 2rem;
        background: var(--dark-bg);
    }

    .products-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .product-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-10px);
        border-color: var(--secondary);
        box-shadow: 0 20px 40px rgba(0, 184, 169, 0.2);
    }

    .product-image-wrapper {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-icon {
        font-size: 5rem;
    }

    .product-type-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--primary);
    }

    .popular-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        background: var(--warning);
        color: white;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .discount-badge {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        background: var(--error);
        color: white;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .product-content {
        padding: 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--text-primary);
    }

    .product-description {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    .product-features {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .feature-icon {
        color: var(--success);
    }

    .product-footer {
        padding-top: 1.5rem;
        border-top: 1px solid var(--dark-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-price {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .price-current {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
    }

    .price-old {
        font-size: 1.1rem;
        color: var(--text-secondary);
        text-decoration: line-through;
    }

    .sales-count {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    @media (max-width: 1024px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .page-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<section class="page-header">
    <div class="page-header-content">
        <div class="page-subtitle">BOUTIQUE</div>
        <h1 class="page-title">Ressources & Formations</h1>
        <p class="page-description">
            Ebooks, templates, formations et services pour accélérer votre croissance.
        </p>
    </div>
</section>

<section class="filters-section">
    <div class="filters-container">
        @foreach($types as $type)
            <a
                href="{{ route('product.index', ['type' => $type]) }}"
                class="filter-btn {{ (!request('type') && $type == 'all') || request('type') == $type ? 'active' : '' }}"
            >
                {{ $type == 'all' ? 'Tous' : ucfirst($type) }}
            </a>
        @endforeach
    </div>
</section>

<section class="products-section">
    <div class="products-container">
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                <a href="{{ route('product.show', $product->slug) }}" class="product-card">

                    <div class="product-image-wrapper">

                        {{-- IMAGE DU PRODUIT --}}
                        @if(!empty($product->image))
                            <img
                                src="{{ route('products.image', basename($product->image)) }}"
                                alt="{{ $product->title }}"
                                style="width:100%; height:100%; object-fit:cover;"
                            >
                        @else
                            {{-- FALLBACK ICÔNE SI PAS D’IMAGE --}}
                            @if($product->type == 'ebook')
                                <div class="product-icon">📚</div>
                            @elseif($product->type == 'formation')
                                <div class="product-icon">🎓</div>
                            @else
                                <div class="product-icon">💼</div>
                            @endif
                        @endif

                        {{-- BADGES --}}
                        <span class="product-type-badge">{{ ucfirst($product->type) }}</span>

                        @if($product->is_popular)
                            <span class="popular-badge">⭐ Populaire</span>
                        @endif

                        @if($product->discount_percentage)
                            <span class="discount-badge">
                                -{{ $product->discount_percentage }}%
                            </span>
                        @endif
                    </div>

                    <div class="product-content">
                        <h3 class="product-title">{{ $product->title }}</h3>

                        <p class="product-description">
                            {{ Str::limit($product->description, 120) }}
                        </p>

                        <div class="product-features">
                            @foreach(array_slice($product->features ?? [], 0, 3) as $feature)
                                <div class="feature-item">
                                    <span class="feature-icon">✓</span>
                                    {{ $feature }}
                                </div>
                            @endforeach
                        </div>

                        <div class="product-footer">
                            <div class="product-price">
                                <span class="price-current">
                                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                </span>

                                @if($product->old_price)
                                    <span class="price-old">
                                        {{ number_format($product->old_price, 0, ',', ' ') }} FCFA
                                    </span>
                                @endif
                            </div>

                            <div class="sales-count">
                                {{ $product->sales_count }} ventes
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach

            </div>

            <div class="pagination-wrapper" style="margin-top: 3rem;">
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-state" style="text-align: center; padding: 6rem 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🛍️</div>
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.8rem; color: var(--text-primary);">Aucun produit trouvé</h3>
                <p style="color: var(--text-secondary); font-size: 1.1rem;">Essayez de modifier vos critères de recherche.</p>
            </div>
        @endif
    </div>
</section>
@endsection
