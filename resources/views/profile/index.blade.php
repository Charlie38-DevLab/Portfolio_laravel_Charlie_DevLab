@extends('layouts.app_layout')

@section('title', 'Mon Profil - Odilon DevLab')

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

    .profile-header {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 3rem;
        margin-bottom: 3rem;
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        font-weight: 700;
    }

    .profile-info h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .profile-email {
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .profile-badges {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .badge-points {
        background: rgba(108, 92, 231, 0.1);
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .btn-clear-all {
        padding: 0.8rem 1.5rem;
        background: var(--dark-bg);
        color: var(--error);
        border: 1px solid var(--error);
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-clear-all:hover {
        background: rgba(255, 71, 87, 0.1);
        transform: translateY(-2px);
    }

    .activity-list {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
    }

    .activity-item {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem;
        border-bottom: 1px solid var(--dark-border);
        transition: all 0.3s ease;
        position: relative;
    }

    .activity-item:hover {
        background: rgba(108, 92, 231, 0.05);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: rgba(108, 92, 231, 0.1);
        flex-shrink: 0;
    }

    .activity-details {
        flex: 1;
    }

    .activity-details h4 {
        font-weight: 600;
        margin-bottom: 0.3rem;
    }

    .activity-time {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .activity-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-delete {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        color: var(--error);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }

    .btn-delete:hover {
        background: rgba(255, 71, 87, 0.1);
        border-color: var(--error);
        transform: scale(1.1);
    }

    .btn-edit {
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-secondary);
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(0, 212, 170, 0.1);
        border: 1px solid var(--success);
        color: var(--success);
    }

    .alert-error {
        background: rgba(255, 71, 87, 0.1);
        border: 1px solid var(--error);
        color: var(--error);
    }

    /* Modal de confirmation */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
    }

    .modal-header {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .modal-body {
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }

    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-cancel {
        padding: 0.8rem 1.5rem;
        background: var(--dark-bg);
        color: var(--text-primary);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        border-color: var(--primary);
    }

    .btn-confirm {
        padding: 0.8rem 1.5rem;
        background: var(--error);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 71, 87, 0.4);
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .section-header {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-hero"></div>

<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- En-tête du profil -->
    <div class="profile-header">
        <div class="profile-avatar">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px;">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div class="profile-info" style="flex: 1;">
            <h1>{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>
            <div class="profile-badges">
                <span class="badge badge-points">⭐ {{ $user->points ?? 0 }} points</span>
                @if($user->badges)
                    @foreach($user->badges as $badge)
                        <span class="badge badge-points">🏆 {{ $badge }}</span>
                    @endforeach
                @endif
            </div>
        </div>
        <div>
            <a href="{{ route('profile.edit') }}" class="btn-edit">Modifier le profil</a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">🛒</div>
            <div class="stat-value">{{ $totalPurchases }}</div>
            <div class="stat-label">Achats effectués</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-value">{{ $totalEvents }}</div>
            <div class="stat-label">Événements inscrits</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💬</div>
            <div class="stat-value">{{ $totalForumPosts }}</div>
            <div class="stat-label">Posts dans le forum</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⭐</div>
            <div class="stat-value">{{ $user->points ?? 0 }}</div>
            <div class="stat-label">Points accumulés</div>
        </div>
    </div>

    <!-- Activités récentes -->
    <div class="section-header">
        <h2 class="section-title">Activités Récentes</h2>
        @if($recentActivities->count() > 0)
            <button class="btn-clear-all" onclick="confirmClearAll()">
                🗑️ Tout supprimer
            </button>
        @endif
    </div>

    <div class="activity-list">
        @forelse($recentActivities as $activity)
            <div class="activity-item" id="activity-{{ $activity->id }}">
                <div class="activity-icon">{{ $activity->icon ?? '📌' }}</div>
                <div class="activity-details">
                    <h4>{{ $activity->title }}</h4>
                    <p>{{ $activity->description }}</p>
                    <p class="activity-time">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
                <div class="activity-actions">
                    <form action="{{ route('profile.activity.delete', $activity->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-delete" onclick="confirmDelete({{ $activity->id }})" title="Supprimer">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <p>Aucune activité récente</p>
            </div>
        @endforelse
    </div>

    <!-- Achats récents -->
    @if($purchases->count() > 0)
        <h2 class="section-title" style="margin-top: 3rem;">Mes Derniers Achats</h2>
        <div class="activity-list">
            @foreach($purchases as $order)
                <div class="activity-item">
                    <div class="activity-icon">📦</div>
                    <div class="activity-details" style="flex: 1;">
                        <h4>{{ $order->product->title }}</h4>
                        <p>{{ number_format($order->amount, 0, ',', ' ') }} FCFA</p>
                        <p class="activity-time">{{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                    @if($order->product->file_path)
                        <a href="{{ asset('storage/' . $order->product->file_path) }}" download class="btn-edit">Télécharger</a>
                    @endif
                </div>
            @endforeach
            @if($totalPurchases > 5)
                <div style="text-align: center; padding: 1rem;">
                    <a href="{{ route('profile.purchases') }}" class="btn-edit">Voir tous mes achats</a>
                </div>
            @endif
        </div>
    @endif

    <!-- Événements récents -->
    @if($events->count() > 0)
        <h2 class="section-title" style="margin-top: 3rem;">Mes Événements</h2>
        <div class="activity-list">
            @foreach($events as $registration)
                <div class="activity-item">
                    <div class="activity-icon">🎯</div>
                    <div class="activity-details">
                        <h4>{{ $registration->event->title }}</h4>
                        <p>{{ $registration->event->event_date->format('d/m/Y à H:i') }}</p>
                        <p class="activity-time">Statut : {{ $registration->status }}</p>
                    </div>
                </div>
            @endforeach
            @if($totalEvents > 5)
                <div style="text-align: center; padding: 1rem;">
                    <a href="{{ route('profile.events') }}" class="btn-edit">Voir tous mes événements</a>
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Modal de confirmation suppression unique -->
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <h3 class="modal-header">Supprimer l'activité ?</h3>
        <p class="modal-body">
            Êtes-vous sûr de vouloir supprimer cette activité ? Cette action est irréversible.
        </p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Annuler</button>
            <button class="btn-confirm" onclick="deleteActivity()">Supprimer</button>
        </div>
    </div>
</div>

<!-- Modal de confirmation suppression totale -->
<div class="modal" id="clearAllModal">
    <div class="modal-content">
        <h3 class="modal-header">Supprimer toutes les activités ?</h3>
        <p class="modal-body">
            Êtes-vous sûr de vouloir supprimer TOUTES vos activités récentes ? Cette action est irréversible.
        </p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeClearAllModal()">Annuler</button>
            <form action="{{ route('profile.activity.clear') }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm">Tout supprimer</button>
            </form>
        </div>
    </div>
</div>

<script>
let activityToDelete = null;

function confirmDelete(activityId) {
    activityToDelete = activityId;
    document.getElementById('deleteModal').classList.add('active');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('active');
    activityToDelete = null;
}

function deleteActivity() {
    if (activityToDelete) {
        const form = document.querySelector(`#activity-${activityToDelete} .delete-form`);
        form.submit();
    }
}

function confirmClearAll() {
    document.getElementById('clearAllModal').classList.add('active');
}

function closeClearAllModal() {
    document.getElementById('clearAllModal').classList.remove('active');
}

// Fermer les modals en cliquant en dehors
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });
});
</script>
@endsection
