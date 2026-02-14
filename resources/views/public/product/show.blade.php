@extends('layouts.app_layout')

@section('title', $product->title . ' - Boutique')

@push('styles')
<style>
    .product-hero {
        padding: 8rem 2rem 4rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .product-hero::before {
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

    .product-hero-content {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        color: var(--primary);
        transform: translateX(-5px);
    }

    .product-image-section {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 20px;
        padding: 4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .product-image-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    }

    .product-icon-large {
        font-size: 12rem;
        position: relative;
        z-index: 1;
    }

    .product-type-badge {
        position: absolute;
        top: 2rem;
        left: 2rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary);
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .popular-badge {
        position: absolute;
        top: 2rem;
        right: 2rem;
        padding: 0.5rem 1rem;
        background: var(--warning);
        color: white;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .product-info-section {
        color: white;
    }

    .product-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.3;
    }

    .product-description-short {
        font-size: 1.2rem;
        line-height: 1.8;
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .price-section {
        display: flex;
        align-items: baseline;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .current-price {
        font-size: 3.5rem;
        font-weight: 800;
    }

    .old-price {
        font-size: 1.8rem;
        text-decoration: line-through;
        opacity: 0.6;
    }

    .discount-badge {
        padding: 0.5rem 1rem;
        background: var(--error);
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-buy {
        flex: 1;
        padding: 1.2rem 2rem;
        background: white;
        color: var(--primary);
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        text-decoration: none;
    }

    .btn-buy:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .product-details-section {
        padding: 4rem 2rem;
        background: var(--dark-bg);
    }

    .product-details-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 4rem;
    }

    .product-main-content {
        display: flex;
        flex-direction: column;
        gap: 3rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
    }

    .product-description-full {
        font-size: 1.15rem;
        line-height: 1.9;
        color: var(--text-secondary);
    }

    .features-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.2rem;
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        border-color: var(--primary);
        transform: translateX(5px);
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: white;
        font-size: 1.2rem;
    }

    .feature-text {
        flex: 1;
        font-size: 1.05rem;
        color: var(--text-primary);
        line-height: 1.6;
    }

    .product-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .sidebar-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--dark-border);
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .related-products-section {
        padding: 4rem 2rem;
        background: var(--dark-card);
    }

    .related-products-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .related-products-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 2rem;
    }

    @media (max-width: 1024px) {
        .product-hero-content {
            grid-template-columns: 1fr;
        }

        .product-details-container {
            grid-template-columns: 1fr;
        }

        .product-sidebar {
            position: static;
        }

        .related-products-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .product-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .related-products-grid {
            grid-template-columns: 1fr;
        }

        .product-title {
            font-size: 2rem;
        }

        .current-price {
            font-size: 2.5rem;
        }

        .cta-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<section class="product-hero">
    <div class="product-hero-content">
        <div class="product-image-section">
            @if($product->type == 'ebook')
                <div class="product-icon-large">📚</div>
            @elseif($product->type == 'formation')
                <div class="product-icon-large">🎓</div>
            @else
                <div class="product-icon-large">💼</div>
            @endif

            <span class="product-type-badge">{{ $product->type }}</span>

            @if($product->is_popular)
                <span class="popular-badge">⭐ Populaire</span>
            @endif
        </div>

        <div class="product-info-section">
            <a href="{{ route('product.index') }}" class="back-link">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Retour à la boutique
            </a>

            <h1 class="product-title">{{ $product->title }}</h1>
            <p class="product-description-short">{{ $product->description }}</p>

            <div class="price-section">
                <span class="current-price">{{ number_format($product->final_price, 0, ',', ' ') }} FCFA</span>
                @if($product->old_price)
                    <span class="old-price">{{ number_format($product->old_price, 0, ',', ' ') }} FCFA</span>
                    <span class="discount-badge">-{{ $product->discount_percentage }}%</span>
                @endif
            </div>

            <div class="cta-buttons">
                <a href="#" class="btn-buy">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
                    </svg>
                    Acheter maintenant
                </a>
            </div>
        </div>
    </div>
</section>

<section class="product-details-section">
    <div class="product-details-container">
        <div class="product-main-content">
            <div>
                <h2 class="section-title">Description</h2>
                <div class="product-description-full">
                    <p>{{ $product->description }}</p>
                    <br>
                    <p>Ce produit a été conçu pour vous aider à atteindre vos objectifs de développement web. Que vous soyez débutant ou développeur expérimenté, vous trouverez ici toutes les ressources nécessaires pour progresser rapidement.</p>
                </div>
            </div>

            @if($product->features)
                <div>
                    <h2 class="section-title">Ce qui est inclus</h2>
                    <div class="features-list">
                        @foreach($product->features as $feature)
                            <div class="feature-item">
                                <div class="feature-icon">✓</div>
                                <span class="feature-text">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <aside class="product-sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-title">Informations</h3>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Type</span>
                        <span class="info-value">{{ ucfirst($product->type) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Prix</span>
                        <span class="info-value">{{ number_format($product->final_price, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @if($product->discount_percentage)
                        <div class="info-item">
                            <span class="info-label">Réduction</span>
                            <span class="info-value" style="color: var(--error);">-{{ $product->discount_percentage }}%</span>
                        </div>
                    @endif
                    <div class="info-item">
                        <span class="info-label">Ventes</span>
                        <span class="info-value">{{ $product->sales_count }} ventes</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Statut</span>
                        <span class="info-value" style="color: var(--success);">{{ $product->is_active ? 'Disponible' : 'Indisponible' }}</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>

@if($similarProducts->count() > 0)
<section class="related-products-section">
    <div class="related-products-container">
        <h2 class="section-title">Produits similaires</h2>
        <div class="related-products-grid">
            @foreach($similarProducts as $similar)
                <a href="{{ route('product.show', $similar->slug) }}" class="product-card" style="display: block;">
                    <div class="product-image-wrapper" style="height: 200px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center;">
                        @if($similar->type == 'ebook')
                            <div class="product-icon" style="font-size: 4rem;">📚</div>
                        @elseif($similar->type == 'formation')
                            <div class="product-icon" style="font-size: 4rem;">🎓</div>
                        @else
                            <div class="product-icon" style="font-size: 4rem;">💼</div>
                        @endif
                    </div>
                    <div class="product-content" style="padding: 1.5rem;">
                        <h3 class="product-title" style="font-size: 1.2rem; margin-bottom: 0.8rem;">{{ Str::limit($similar->title, 50) }}</h3>
                        <p class="product-description" style="font-size: 0.9rem; margin-bottom: 1rem;">{{ Str::limit($similar->description, 80) }}</p>
                        <div class="product-footer" style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid var(--dark-border);">
                            <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">{{ number_format($similar->final_price, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
