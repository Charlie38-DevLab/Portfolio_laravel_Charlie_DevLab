@extends('layouts.app_layout')

@section('title', 'Mes Événements - Odilon DevLab')

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

    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }

    .event-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .event-card:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(108, 92, 231, 0.2);
    }

    .event-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
    }

    .event-content {
        padding: 2rem;
    }

    .event-type {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .event-type.webinaire {
        background: rgba(102, 126, 234, 0.1);
        color: #667EEA;
        border: 1px solid #667EEA;
    }

    .event-type.masterclass {
        background: rgba(0, 212, 170, 0.1);
        color: #00D4AA;
        border: 1px solid #00D4AA;
    }

    .event-type.conference {
        background: rgba(162, 155, 254, 0.1);
        color: #A29BFE;
        border: 1px solid #A29BFE;
    }

    .event-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .event-info {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .info-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .status-registered {
        background: rgba(0, 212, 170, 0.1);
        color: var(--success);
        border: 1px solid var(--success);
    }

    .status-attended {
        background: rgba(108, 92, 231, 0.1);
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .status-cancelled {
        background: rgba(255, 71, 87, 0.1);
        color: var(--error);
        border: 1px solid var(--error);
    }

    .event-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .btn-view {
        flex: 1;
        padding: 0.8rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
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

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .events-grid {
            grid-template-columns: 1fr;
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
        <h1 class="page-title">Mes Événements</h1>
        <a href="{{ route('profile.index') }}" class="btn-back">
            ← Retour au profil
        </a>
    </div>

    @if($events->count() > 0)
        <div class="events-grid">
            @foreach($events as $registration)
                @php
                    $event = $registration->event;
                @endphp
                <div class="event-card">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="event-image">
                    @else
                        <div class="event-image"></div>
                    @endif

                    <div class="event-content">
                        <span class="event-type {{ $event->type }}">{{ ucfirst($event->type) }}</span>

                        <h3 class="event-title">{{ $event->title }}</h3>

                        <div class="event-info">
                            <div class="info-item">
                                <span class="info-icon">📅</span>
                                <span>{{ $event->event_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-icon">🕐</span>
                                <span>{{ $event->event_date->format('H:i') }} - {{ $event->duration_minutes }} min</span>
                            </div>
                            <div class="info-item">
                                <span class="info-icon">📍</span>
                                <span>{{ $event->location }}</span>
                            </div>
                            @if($registration->has_coaching)
                                <div class="info-item">
                                    <span class="info-icon">✨</span>
                                    <span>Avec accompagnement</span>
                                </div>
                            @endif
                        </div>

                        <div class="event-status status-{{ $registration->status }}">
                            @if($registration->status === 'registered')
                                ✓ Inscrit
                            @elseif($registration->status === 'attended')
                                ✓ Participé
                            @else
                                ✗ Annulé
                            @endif
                        </div>

                        <div class="event-actions">
                            <a href="{{ route('events.show', $event->id) }}" class="btn-view">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($events, 'links'))
            <div class="pagination">
                {{ $events->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📅</div>
            <h3>Aucun événement inscrit</h3>
            <p>Vous n'êtes inscrit à aucun événement pour le moment.</p>
            <a href="{{ route('events.index') }}" class="btn-browse">
                Découvrir les événements
            </a>
        </div>
    @endif
</div>
@endsection
