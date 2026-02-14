@extends('layouts.app_layout')

@section('title', 'Mes Achats - Odilon DevLab')

@push('styles')
<style>
    .profile-hero {
        padding: 8rem 2rem 4rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .profile-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 3rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .btn-back {
        padding: 1rem 2rem;
        background: var(--dark-card);
        color: var(--text-primary);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
    }

    .purchases-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .purchase-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
        display: flex;
        gap: 2rem;
        align-items: center;
        transition: all 0.3s ease;
    }

    .purchase-card:hover {
        border-color: var(--primary);
        transform: translateX(5px);
    }

    .purchase-image {
        width: 150px;
        height: 150px;
        border-radius: 15px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        flex-shrink: 0;
    }

    .purchase-details {
        flex: 1;
    }

    .purchase-type {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .type-ebook {
        background: rgba(102, 126, 234, 0.1);
        color: #667EEA;
        border: 1px solid #667EEA;
    }

    .type-formation {
        background: rgba(0, 212, 170, 0.1);
        color: #00D4AA;
        border: 1px solid #00D4AA;
    }

    .type-service {
        background: rgba(162, 155, 254, 0.1);
        color: #A29BFE;
        border: 1px solid #A29BFE;
    }

    .type-cv, .type-portfolio {
        background: rgba(255, 165, 0, 0.1);
        color: #FFA500;
        border: 1px solid #FFA500;
    }

    .purchase-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--text-primary);
    }

    .purchase-info {
        display: flex;
        gap: 2rem;
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .purchase-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .purchase-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .status-completed {
        background: rgba(0, 212, 170, 0.1);
        color: var(--success);
        border: 1px solid var(--success);
    }

    .status-pending {
        background: rgba(255, 165, 0, 0.1);
        color: #FFA500;
        border: 1px solid #FFA500;
    }

    .status-cancelled {
        background: rgba(255, 71, 87, 0.1);
        color: var(--error);
        border: 1px solid var(--error);
    }

    .purchase-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        align-items: flex-end;
    }

    .btn-download {
        padding: 0.8rem 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
    }

    .btn-view {
        padding: 0.8rem 1.5rem;
        background: var(--dark-bg);
        color: var(--text-primary);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
    }

    .order-number {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
    }

    .empty-state-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }

    .btn-browse {
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-browse:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.4);
    }

    .total-spent {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .total-spent-label {
        font-size: 1rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .total-spent-amount {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
    }

    @media (max-width: 968px) {
        .purchase-card {
            flex-direction: column;
            text-align: center;
        }

        .purchase-info {
            flex-direction: column;
            gap: 0.5rem;
        }

        .purchase-actions {
            width: 100%;
            align-items: stretch;
        }

        .btn-download, .btn-view {
            width: 100%;
            justify-content: center;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-hero"></div>

<div class="profile-container">
    <div class="page-header">
        <h1 class="page-title">Mes Achats</h1>
        <a href="{{ route('profile.index') }}" class="btn-back">
            ← Retour au profil
        </a>
    </div>

    @if($purchases->count() > 0)
        @php
            $totalSpent = $purchases->sum('amount');
        @endphp

        <div class="total-spent">
            <div class="total-spent-label">Total dépensé</div>
            <div class="total-spent-amount">{{ number_format($totalSpent, 0, ',', ' ') }} FCFA</div>
        </div>

        <div class="purchases-list">
            @foreach($purchases as $order)
                @php
                    $product = $order->product;
                @endphp
                <div class="purchase-card">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="purchase-image">
                    @else
                        <div class="purchase-image"></div>
                    @endif

                    <div class="purchase-details">
                        <span class="purchase-type type-{{ $product->type }}">
                            {{ ucfirst($product->type) }}
                        </span>

                        <h3 class="purchase-title">{{ $product->title }}</h3>

                        <div class="purchase-info">
                            <div class="info-item">
                                <span>📅</span>
                                <span>Acheté le {{ $order->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span>💳</span>
                                <span>{{ $order->payment_method ?? 'Carte bancaire' }}</span>
                            </div>
                        </div>

                        <div class="purchase-price">
                            {{ number_format($order->amount, 0, ',', ' ') }} FCFA
                        </div>

                        <div class="purchase-status status-{{ $order->status }}">
                            @if($order->status === 'completed')
                                ✓ Terminé
                            @elseif($order->status === 'pending')
                                ⏳ En attente
                            @else
                                ✗ Annulé
                            @endif
                        </div>

                        <div class="order-number">
                            Commande #{{ $order->order_number }}
                        </div>
                    </div>

                    <div class="purchase-actions">
                        @if($order->status === 'completed' && $product->file_path)
                            <a href="{{ asset('storage/' . $product->file_path) }}" download class="btn-download">
                                📥 Télécharger
                            </a>
                        @endif
                        <a href="{{ route('shop.show', $product->id) }}" class="btn-view">
                            👁️ Voir le produit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($purchases, 'links'))
            <div class="pagination" style="margin-top: 3rem;">
                {{ $purchases->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🛒</div>
            <h3>Aucun achat effectué</h3>
            <p>Vous n'avez pas encore effectué d'achat sur notre plateforme.</p>
            <a href="{{ route('shop.index') }}" class="btn-browse">
                Découvrir la boutique
            </a>
        </div>
    @endif
</div>
@endsection
