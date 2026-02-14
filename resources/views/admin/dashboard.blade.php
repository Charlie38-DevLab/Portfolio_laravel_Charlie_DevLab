@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="admin-header">
    <h1>Tableau de Bord</h1>
    <p>Bienvenue sur votre espace administrateur</p>
</div>

<!-- Statistiques -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667EEA, #764BA2);">
            👥
        </div>
        <div class="stat-info">
            <h3>{{ $stats['total_users'] }}</h3>
            <p>Utilisateurs</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #00D4AA, #00B8A9);">
            💼
        </div>
        <div class="stat-info">
            <h3>{{ $stats['total_projects'] }}</h3>
            <p>Projets</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #FFA500, #FF8B4D);">
            🛍️
        </div>
        <div class="stat-info">
            <h3>{{ $stats['total_products'] }}</h3>
            <p>Produits</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #A29BFE, #6C5CE7);">
            📅
        </div>
        <div class="stat-info">
            <h3>{{ $stats['total_events'] }}</h3>
            <p>Événements</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #00D4AA, #128C7E);">
            💰
        </div>
        <div class="stat-info">
            <h3>{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</h3>
            <p>Revenus</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #FF6B6B, #EE5A6F);">
            📦
        </div>
        <div class="stat-info">
            <h3>{{ $stats['total_orders'] }}</h3>
            <p>Commandes</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #FFB800, #FFA000);">
            ⏳
        </div>
        <div class="stat-info">
            <h3>{{ $stats['pending_orders'] }}</h3>
            <p>En attente</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #2D8CFF, #0B5ED7);">
            ✉️
        </div>
        <div class="stat-info">
            <h3>{{ $stats['unread_contacts'] }}</h3>
            <p>Messages non lus</p>
        </div>
    </div>
</div>

<!-- Section commandes récentes et événements -->
<div class="dashboard-grid">
    <!-- Dernières commandes -->
    <div class="dashboard-card">
        <div class="card-header">
            <h2>Dernières Commandes</h2>
            <a href="{{ route('admin.orders.index') }}" class="btn-link">Voir tout</a>
            {{-- <a href="#" class="btn-link">Voir tout</a> --}}
        </div>
        <div class="table-responsive">
            @if($recentOrders->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Produit</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->product->title }}</td>
                                <td>{{ number_format($order->amount, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty-state">Aucune commande récente</p>
            @endif
        </div>
    </div>

    <!-- Prochains événements -->
    <div class="dashboard-card">
        <div class="card-header">
            <h2>Prochains Événements</h2>
            {{-- <a href="{{ route('admin.events.index') }}" class="btn-link">Voir tout</a> --}}
        </div>
        <div class="events-list">
            @if($upcomingEvents->count() > 0)
                @foreach($upcomingEvents as $event)
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">{{ $event->event_date->format('d') }}</span>
                            <span class="month">{{ $event->event_date->format('M') }}</span>
                        </div>
                        <div class="event-info">
                            <h4>{{ $event->title }}</h4>
                            <p>{{ $event->registered_count }} inscrits</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="empty-state">Aucun événement à venir</p>
            @endif
        </div>
    </div>
</div>

<!-- Messages récents -->
<div class="dashboard-card">
    <div class="card-header">
        <h2>Messages Récents</h2>
        <a href="{{ route('admin.contacts.index') }}" class="btn-link">Voir tout</a>
    </div>
    <div class="table-responsive">
        @if($recentContacts->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Sujet</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentContacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $contact->status }}">
                                    {{ ucfirst($contact->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty-state">Aucun message récent</p>
        @endif
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: var(--dark-card);
    border: 1px solid var(--dark-border);
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.stat-info h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}

.stat-info p {
    color: var(--text-secondary);
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.dashboard-card {
    background: var(--dark-card);
    border: 1px solid var(--dark-border);
    border-radius: 15px;
    padding: 2rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.card-header h2 {
    font-size: 1.3rem;
    font-weight: 700;
}

.btn-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: var(--text-secondary);
}

@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
