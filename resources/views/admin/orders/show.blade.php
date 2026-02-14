@extends('layouts.admin')

@section('title', 'Commande #' . $order->order_number)

@section('content')
<div class="admin-header">
    <h1>Commande #{{ $order->order_number }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        ← Retour à la liste
    </a>
</div>

<div style="max-width: 1000px;">
    <div class="card">
        <!-- Statut et Date -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--dark-border);">
            <div>
                @if($order->status === 'completed')
                    <span class="badge badge-completed" style="font-size: 1rem; padding: 0.8rem 1.5rem;">
                        ✅ Commande complétée
                    </span>
                @elseif($order->status === 'pending')
                    <span class="badge badge-pending" style="font-size: 1rem; padding: 0.8rem 1.5rem;">
                        ⏳ En attente
                    </span>
                @else
                    <span class="badge badge-cancelled" style="font-size: 1rem; padding: 0.8rem 1.5rem;">
                        ❌ Annulée
                    </span>
                @endif
            </div>
            <div style="color: var(--text-secondary);">
                {{ $order->created_at->format('d/m/Y à H:i') }}
            </div>
        </div>

        <!-- Informations Client -->
        <div style="background: rgba(108, 92, 231, 0.05); padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
            <h3 style="font-size: 1.3rem; margin-bottom: 1.5rem;">👤 Informations Client</h3>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                        Nom
                    </div>
                    <div style="font-weight: 600; font-size: 1.1rem;">
                        {{ $order->user->name }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                        Email
                    </div>
                    <div style="font-weight: 600; font-size: 1.1rem;">
                        <a href="mailto:{{ $order->user->email }}" style="color: var(--primary); text-decoration: none;">
                            {{ $order->user->email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations Produit -->
        <div style="background: rgba(0, 212, 170, 0.05); padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
            <h3 style="font-size: 1.3rem; margin-bottom: 1.5rem;">📦 Produit Commandé</h3>
            <div style="display: flex; gap: 2rem; align-items: start;">
                @if($order->product->image)
                    <img src="{{ asset('storage/' . $order->product->image) }}"
                         alt="{{ $order->product->title }}"
                         style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
                @else
                    <div style="width: 150px; height: 150px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 10px;"></div>
                @endif
                <div style="flex: 1;">
                    <h4 style="font-size: 1.2rem; margin-bottom: 0.5rem;">{{ $order->product->title }}</h4>
                    <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                        {{ Str::limit($order->product->description, 150) }}
                    </p>
                    <div style="display: flex; gap: 2rem;">
                        <div>
                            <div style="font-size: 0.85rem; color: var(--text-secondary);">Type</div>
                            <div style="font-weight: 600;">{{ ucfirst($order->product->type) }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: var(--text-secondary);">Prix</div>
                            <div style="font-weight: 600; color: var(--primary);">
                                {{ number_format($order->amount, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails Paiement -->
        <div style="background: rgba(255, 184, 0, 0.05); padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
            <h3 style="font-size: 1.3rem; margin-bottom: 1.5rem;">💳 Détails du Paiement</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                        Montant
                    </div>
                    <div style="font-weight: 700; font-size: 1.5rem; color: var(--primary);">
                        {{ number_format($order->amount, 0, ',', ' ') }} FCFA
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                        Méthode
                    </div>
                    <div style="font-weight: 600;">
                        {{ $order->payment_method ?? 'Non spécifié' }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                        ID Transaction
                    </div>
                    <div style="font-weight: 600; font-family: monospace;">
                        {{ $order->transaction_id ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 2rem; border-top: 1px solid var(--dark-border);">
            <!-- Changer le statut -->
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="display: flex; gap: 1rem; align-items: center;">
                @csrf
                <label style="font-weight: 600;">Changer le statut :</label>
                <select name="status" class="form-select" style="width: 200px;" onchange="this.form.submit()">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✅ Complété</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Annulé</option>
                </select>
            </form>

            <!-- Supprimer -->
            <form action="{{ route('admin.orders.destroy', $order->id) }}"
                  method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    🗑️ Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
