@extends('layouts.admin')

@section('title', 'Gestion des Commandes')

@push('styles')
<style>
/* ===== HEADER ===== */
.admin-header {
    margin-bottom: 3rem;
}
.admin-header h1 {
    font-size: 2rem;
    font-weight: 800;
}
.admin-header p {
    color: var(--text-secondary);
}

/* ===== STATS ===== */
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

/* ===== TABLE ===== */
.table-wrapper {
    overflow-x: auto;
}
.data-table {
    width: 100%;
    border-collapse: collapse;
}
.data-table thead {
    background: #0f122b;
}
.data-table th {
    padding: 1rem;
    text-align: left;
    font-size: .85rem;
    text-transform: uppercase;
    color: var(--text-secondary);
}
.data-table td {
    padding: 1rem;
    border-top: 1px solid var(--dark-border);
    font-size: .9rem;
}
.data-table tbody tr:hover {
    background: rgba(255,255,255,.02);
}

/* ===== USER ===== */
.user-box {
    display: flex;
    flex-direction: column;
}
.user-box strong {
    color: var(--text-primary);
}
.user-box span {
    font-size: .8rem;
    color: var(--text-secondary);
}

/* ===== BADGES ===== */
.badge {
    padding: .35rem .8rem;
    border-radius: 999px;
    font-size: .7rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: .3rem;
}
.badge-completed {
    background: rgba(0,212,170,.15);
    color: #00D4AA;
}
.badge-pending {
    background: rgba(255,184,0,.15);
    color: #FFB800;
}
.badge-cancelled {
    background: rgba(255,107,107,.15);
    color: #FF6B6B;
}

/* ===== ACTIONS ===== */
.table-actions {
    display: flex;
    gap: .4rem;
}
.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1px solid var(--dark-border);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background: transparent;
    transition: .25s;
}
.action-btn:hover {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}
.action-btn.delete:hover {
    background: var(--error);
    border-color: var(--error);
}

/* ===== PAGINATION ===== */
.pagination {
    padding: 2rem;
    display: flex;
    justify-content: center;
}

/* ===== EMPTY ===== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}
.empty-state div {
    font-size: 4rem;
    opacity: .4;
}
</style>
@endpush

@section('content')

<div class="admin-header">
    <h1>Gestion des Commandes</h1>
    <p>Suivi et administration des commandes clients</p>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#667EEA,#764BA2)">📦</div>
        <div class="stat-info">
            <h3>{{ $stats['total'] }}</h3>
            <p>Total commandes</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#00D4AA,#00B8A9)">✅</div>
        <div class="stat-info">
            <h3>{{ $stats['completed'] }}</h3>
            <p>Complétées</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#FFB800,#FFA000)">⏳</div>
        <div class="stat-info">
            <h3>{{ $stats['pending'] }}</h3>
            <p>En attente</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#FF6B6B,#EE5A6F)">❌</div>
        <div class="stat-info">
            <h3>{{ $stats['cancelled'] }}</h3>
            <p>Annulées</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:linear-gradient(135deg,#00D4AA,#128C7E)">💰</div>
        <div class="stat-info">
            <h3>{{ number_format($stats['revenue'],0,' ',' ') }} FCFA</h3>
            <p>Revenus</p>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="card">
@if($orders->count())
<div class="table-wrapper">
<table class="data-table">
    <thead>
        <tr>
            <th>N°</th>
            <th>Client</th>
            <th>Produit</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td><strong>#{{ $order->order_number }}</strong></td>

            <td>
                <div class="user-box">
                    <strong>{{ $order->user->name }}</strong>
                    <span>{{ $order->user->email }}</span>
                </div>
            </td>

            <td>{{ Str::limit($order->product->title,40) }}</td>

            <td><strong style="color:var(--primary)">
                {{ number_format($order->amount,0,' ',' ') }} FCFA
            </strong></td>

            <td>
                @if($order->status === 'completed')
                    <span class="badge badge-completed">✅ Complété</span>
                @elseif($order->status === 'pending')
                    <span class="badge badge-pending">⏳ En attente</span>
                @else
                    <span class="badge badge-cancelled">❌ Annulé</span>
                @endif
            </td>

            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>

            <td>
                <div class="table-actions">
                    <a href="{{ route('admin.orders.show',$order->id) }}" class="action-btn" title="Voir">
                        👁️
                    </a>
                    <form action="{{ route('admin.orders.destroy',$order->id) }}"
                          method="POST"
                          onsubmit="return confirm('Supprimer cette commande ?')">
                        @csrf @method('DELETE')
                        <button class="action-btn delete" title="Supprimer">🗑️</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<div class="pagination">{{ $orders->links() }}</div>
@else
<div class="empty-state">
    <div>📦</div>
    <p>Aucune commande enregistrée</p>
</div>
@endif
</div>

@endsection
