@extends('layouts.app_layout')

@section('content')
<div class="events-page">
    <!-- Hero Section -->
    <section class="events-hero">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <span class="hero-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    ÉVÉNEMENTS
                </span>
                <h1 class="hero-title">Webinaires & Masterclass</h1>
                <p class="hero-description">
                    Participez à mes événements gratuits et découvrez les accompagnements personnalisés disponibles pour accélérer votre apprentissage.
                </p>

                <!-- Stats -->
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $events->count() }}</span>
                        <span class="stat-label">Événements</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $events->where('is_free', true)->count() }}</span>
                        <span class="stat-label">Gratuits</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $events->sum('registered_count') }}</span>
                        <span class="stat-label">Participants</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="events-filters">
        <div class="container">
            <div class="filters-wrapper">
                <!-- Search Bar -->
                <div class="search-container">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="text"
                           class="search-input"
                           placeholder="Rechercher un événement..."
                           id="eventSearch">
                </div>

                <!-- Type Filters -->
                <div class="filter-tabs">
                    <a href="?type=all" class="filter-tab {{ $selectedType === 'all' ? 'active' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        Tous
                    </a>
                    <a href="?type=webinaire" class="filter-tab {{ $selectedType === 'webinaire' ? 'active' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                        Webinaires
                    </a>
                    <a href="?type=masterclass" class="filter-tab {{ $selectedType === 'masterclass' ? 'active' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        </svg>
                        Masterclass
                    </a>
                    <a href="?type=conference" class="filter-tab {{ $selectedType === 'conference' ? 'active' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        </svg>
                        Conférences
                    </a>
                    <a href="?type=formation" class="filter-tab {{ $selectedType === 'formation' ? 'active' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                        Formations
                    </a>
                    <a href="?type=atelier" class="filter-tab {{ $selectedType === 'atelier' ? 'active' : '' }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                        </svg>
                        Ateliers
                    </a>
                </div>

                <!-- Status Filters -->
                <div class="filter-tags">
                    <a href="?status=all" class="filter-tag {{ $selectedStatus === 'all' ? 'active' : '' }}">
                        Tous
                    </a>
                    <a href="?status=upcoming" class="filter-tag {{ $selectedStatus === 'upcoming' ? 'active' : '' }}">
                        À venir
                    </a>
                    <a href="?status=live" class="filter-tag {{ $selectedStatus === 'live' ? 'active' : '' }}">
                        En direct
                    </a>
                    <a href="?status=replay" class="filter-tag {{ $selectedStatus === 'replay' ? 'active' : '' }}">
                        Replay
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="events-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <span class="title-dot"></span>
                    Événements Disponibles
                </h2>
                <p class="section-subtitle">Découvrez nos prochains événements et inscrivez-vous gratuitement</p>
            </div>

            @if($events->isEmpty())
                <div class="empty-state" data-aos="fade-up">
                    <div class="empty-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="empty-title">Aucun événement trouvé</h3>
                    <p class="empty-description">Consultez régulièrement cette page pour découvrir nos prochains événements ou modifiez vos filtres de recherche.</p>
                    <a href="{{ route('events.index') }}" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <polyline points="1 4 1 10 7 10"></polyline>
                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                        </svg>
                        Réinitialiser les filtres
                    </a>
                </div>
            @else
                <div class="events-grid">
                    @foreach($events as $event)
                        <article class="event-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="event-image">
                                <img src="{{ $event->image }}" alt="{{ $event->title }}" loading="lazy">

                                <!-- Overlay gradient -->
                                <div class="image-overlay"></div>

                                <!-- Badges -->
                                <div class="event-badges">
                                    <span class="badge badge-{{ $event->type }}">{{ ucfirst($event->type) }}</span>
                                    @if($event->event_date > now())
                                        <span class="badge badge-upcoming">À venir</span>
                                    @elseif($event->event_date > now()->subHours(3))
                                        <span class="badge badge-live">
                                            <span class="live-dot"></span>
                                            En direct
                                        </span>
                                    @else
                                        <span class="badge badge-replay">Replay</span>
                                    @endif
                                </div>

                                <!-- Price Badge -->
                                <div class="price-badge">
                                    @if($event->is_free)
                                        <span class="price-free">GRATUIT</span>
                                    @else
                                        <span class="price-amount">{{ number_format($event->price, 0, ',', ' ') }}</span>
                                        <span class="price-currency">FCFA</span>
                                    @endif
                                </div>

                                <!-- Date Badge -->
                                <div class="event-date-badge">
                                    <div class="date-day">{{ $event->event_date->format('d') }}</div>
                                    <div class="date-month">{{ strtoupper($event->event_date->translatedFormat('M')) }}</div>
                                </div>
                            </div>

                            <div class="event-content">
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <p class="event-description">{{ Str::limit($event->description, 120) }}</p>

                                <div class="event-meta">
                                    <div class="meta-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <span>{{ $event->event_date->format('H:i') }} • {{ $event->duration }}</span>
                                    </div>

                                    <div class="meta-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span>{{ $event->location }}</span>
                                    </div>

                                    @if($event->max_participants)
                                        <div class="meta-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                            <span>{{ $event->available_slots }} places restantes</span>
                                        </div>
                                    @endif
                                </div>

                                @if($event->features)
                                    <div class="event-features">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span>{{ Str::limit($event->features, 80) }}</span>
                                    </div>
                                @endif

                                <div class="event-footer">
                                    <a href="{{ route('events.show', $event->slug) }}" class="event-btn">
                                        <span>Voir les détails</span>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>

                                    @if($event->is_featured)
                                        <div class="featured-badge">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="pagination-container" data-aos="fade-up">
                        {{ $events->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>

    <!-- Info Sections -->
    <section class="info-section">
        <div class="container">
            <div class="info-grid">
                <div class="info-card" data-aos="fade-up">
                    <div class="info-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </div>
                    <h3 class="info-title">Webinaires Gratuits</h3>
                    <p class="info-description">
                        Participez gratuitement à mes webinaires et découvrez de nouvelles compétences en développement web, intelligence artificielle et technologies modernes.
                    </p>
                    <a href="?type=webinaire" class="info-link">
                        Voir les webinaires
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>

                <div class="info-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        </svg>
                    </div>
                    <h3 class="info-title">Accompagnement Personnalisé</h3>
                    <p class="info-description">
                        Après chaque webinaire, profitez d'un accompagnement payant pour approfondir vos connaissances et atteindre vos objectifs plus rapidement.
                    </p>
                    <a href="#" class="info-link">
                        En savoir plus
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>

                <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="info-title">Communauté Active</h3>
                    <p class="info-description">
                        Rejoignez une communauté de développeurs passionnés, échangez vos expériences et construisez votre réseau professionnel.
                    </p>
                    <a href="#" class="info-link">
                        Rejoindre
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-card" data-aos="fade-up">
                <div class="newsletter-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <div class="newsletter-content">
                    <h3 class="newsletter-title">Ne manquez aucun événement</h3>
                    <p class="newsletter-description">Inscrivez-vous à la newsletter pour recevoir les dernières actualités et événements</p>
                </div>
                <a href="#" class="btn btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    S'inscrire
                </a>
            </div>
        </div>
    </section>
</div>

<style>
:root {
    --primary: #6366f1;
    --secondary: #8b5cf6;
    --accent: #ec4899;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark-bg: #0f172a;
    --card-bg: #1e293b;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border: #334155;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: var(--dark-bg);
    color: var(--text-primary);
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Hero Section */
.events-hero {
    position: relative;
    padding: 100px 0 80px;
    background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
    overflow: hidden;
}

.hero-background {
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

@keyframes gradient-shift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.hero-content {
    text-align: center;
    position: relative;
    z-index: 1;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.3);
    border-radius: 24px;
    color: var(--primary);
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 24px;
}

.hero-badge svg {
    stroke-width: 2;
}

.hero-title {
    font-size: 56px;
    font-weight: 800;
    background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
    line-height: 1.2;
}

.hero-description {
    font-size: 20px;
    color: var(--text-secondary);
    max-width: 700px;
    margin: 0 auto 40px;
    line-height: 1.7;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 60px;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.stat-number {
    font-size: 40px;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 14px;
    color: var(--text-secondary);
    font-weight: 500;
}

/* Filters Section */
.events-filters {
    padding: 32px 0;
    background: var(--dark-bg);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(12px);
}

.filters-wrapper {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Search */
.search-container {
    position: relative;
    max-width: 600px;
    width: 100%;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    stroke-width: 2;
}

.search-input {
    width: 100%;
    padding: 14px 16px 14px 48px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    color: var(--text-primary);
    font-size: 15px;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Filter Tabs */
.filter-tabs {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding-bottom: 4px;
}

.filter-tab {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.filter-tab svg {
    stroke-width: 2;
}

.filter-tab:hover {
    background: rgba(99, 102, 241, 0.1);
    border-color: var(--primary);
    color: var(--primary);
}

.filter-tab.active {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

/* Filter Tags */
.filter-tags {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-tag {
    padding: 8px 16px;
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 20px;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.filter-tag:hover {
    border-color: var(--secondary);
    color: var(--secondary);
    background: rgba(139, 92, 246, 0.1);
}

.filter-tag.active {
    background: var(--secondary);
    border-color: var(--secondary);
    color: white;
}

/* Events Section */
.events-section {
    padding: 80px 0;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-title {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    font-size: 32px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 12px;
}

.title-dot {
    width: 10px;
    height: 10px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 50%;
}

.section-subtitle {
    font-size: 16px;
    color: var(--text-secondary);
}

/* Events Grid */
.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 32px;
}

/* Event Card */
.event-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.event-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    border-color: var(--primary);
}

.event-image {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.event-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.event-card:hover .event-image img {
    transform: scale(1.1);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(15, 23, 42, 0.7) 100%);
}

.event-badges {
    position: absolute;
    top: 16px;
    left: 16px;
    right: 16px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    z-index: 2;
}

.badge {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    backdrop-filter: blur(8px);
}

.badge-webinaire { background: rgba(59, 130, 246, 0.9); color: white; }
.badge-masterclass { background: rgba(139, 92, 246, 0.9); color: white; }
.badge-conference { background: rgba(16, 185, 129, 0.9); color: white; }
.badge-formation { background: rgba(245, 158, 11, 0.9); color: white; }
.badge-atelier { background: rgba(236, 72, 153, 0.9); color: white; }
.badge-upcoming { background: rgba(100, 116, 139, 0.9); color: white; }
.badge-replay { background: rgba(100, 116, 139, 0.9); color: white; }

.badge-live {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(239, 68, 68, 0.9);
    color: white;
}

.live-dot {
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
}

.price-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    padding: 8px 16px;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    text-align: center;
    z-index: 2;
}

.price-free {
    font-size: 14px;
    font-weight: 800;
    color: var(--success);
}

.price-amount {
    display: block;
    font-size: 20px;
    font-weight: 800;
    color: var(--warning);
    line-height: 1;
}

.price-currency {
    display: block;
    font-size: 10px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-top: 2px;
}

.event-date-badge {
    position: absolute;
    bottom: 16px;
    right: 16px;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 12px 16px;
    text-align: center;
    min-width: 80px;
    z-index: 2;
}

.date-day {
    font-size: 32px;
    font-weight: 800;
    line-height: 1;
    color: var(--primary);
}

.date-month {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-top: 4px;
}

.event-content {
    padding: 24px;
}

.event-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text-primary);
    line-height: 1.3;
}

.event-description {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 20px;
    line-height: 1.7;
}

.event-meta {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 16px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: var(--text-secondary);
}

.meta-item svg {
    stroke-width: 2;
    color: var(--primary);
    flex-shrink: 0;
}

.event-features {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px;
    background: rgba(99, 102, 241, 0.05);
    border-left: 3px solid var(--primary);
    border-radius: 6px;
    margin-bottom: 20px;
}

.event-features svg {
    flex-shrink: 0;
    margin-top: 2px;
    color: var(--success);
    stroke-width: 2.5;
}

.event-features span {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.5;
}

.event-footer {
    position: relative;
}

.event-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px 24px;
    background: var(--primary);
    color: white;
    font-size: 15px;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid var(--primary);
}

.event-btn:hover {
    background: transparent;
    color: var(--primary);
    transform: translateX(4px);
}

.event-btn svg {
    transition: transform 0.3s ease;
    stroke-width: 2.5;
}

.event-btn:hover svg {
    transform: translateX(4px);
}

.featured-badge {
    position: absolute;
    top: -40px;
    right: 12px;
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
}

.featured-badge svg {
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 100px 20px;
}

.empty-icon {
    margin-bottom: 24px;
}

.empty-icon svg {
    stroke-width: 1.5;
    color: var(--text-secondary);
}

.empty-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text-primary);
}

.empty-description {
    font-size: 16px;
    color: var(--text-secondary);
    max-width: 500px;
    margin: 0 auto 32px;
    line-height: 1.7;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary);
    color: white;
    border: 2px solid var(--primary);
}

.btn-primary:hover {
    background: var(--secondary);
    border-color: var(--secondary);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
}

.btn svg {
    stroke-width: 2;
}

/* Info Section */
.info-section {
    padding: 80px 0;
    background: linear-gradient(180deg, var(--dark-bg) 0%, #1e293b 100%);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 32px;
}

.info-card {
    padding: 40px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    transition: all 0.4s ease;
}

.info-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.info-icon {
    width: 64px;
    height: 64px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
}

.info-icon svg {
    stroke-width: 2;
    color: white;
}

.info-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text-primary);
}

.info-description {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 20px;
}

.info-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.info-link:hover {
    gap: 12px;
}

.info-link svg {
    stroke-width: 2.5;
}

/* Newsletter Section */
.newsletter-section {
    padding: 60px 0 80px;
}

.newsletter-card {
    display: flex;
    align-items: center;
    gap: 32px;
    padding: 48px;
    background: linear-gradient(135deg, var(--card-bg), #1a2332);
    border: 1px solid var(--border);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.newsletter-icon {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 20px;
}

.newsletter-icon svg {
    stroke-width: 2;
    color: white;
}

.newsletter-content {
    flex: 1;
}

.newsletter-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--text-primary);
}

.newsletter-description {
    font-size: 15px;
    color: var(--text-secondary);
}

/* Pagination */
.pagination-container {
    margin-top: 60px;
    display: flex;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 36px;
    }

    .hero-description {
        font-size: 16px;
    }

    .hero-stats {
        gap: 32px;
    }

    .events-grid {
        grid-template-columns: 1fr;
    }

    .filter-tabs {
        flex-wrap: wrap;
    }

    .newsletter-card {
        flex-direction: column;
        text-align: center;
        padding: 32px 24px;
    }

    .section-title {
        font-size: 24px;
    }
}
</style>

<script>
// Search functionality
document.getElementById('eventSearch')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.event-card');

    cards.forEach(card => {
        const title = card.querySelector('.event-title').textContent.toLowerCase();
        const description = card.querySelector('.event-description').textContent.toLowerCase();

        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection


{{-- @extends('layouts.app_layout')

@section('content')
<div class="events-page">
    <!-- Hero Section -->
    <section class="events-hero">
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    ÉVÉNEMENTS
                </span>
                <h1 class="hero-title">Webinaires & Masterclass</h1>
                <p class="hero-description">
                    Participez à mes événements gratuits et découvrez les accompagnements personnalisés disponibles.
                </p>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="events-filters">
        <div class="container">
            <div class="filters-wrapper">
                <!-- Search Bar -->
                <div class="search-container">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="text"
                           class="search-input"
                           placeholder="Rechercher un événement..."
                           id="eventSearch">
                </div>

                <!-- Type Filters -->
                <div class="filter-tabs">
                    <a href="?type=all" class="filter-tab {{ $selectedType === 'all' ? 'active' : '' }}">Tous</a>
                    <a href="?type=webinaire" class="filter-tab {{ $selectedType === 'webinaire' ? 'active' : '' }}">Webinaires</a>
                    <a href="?type=masterclass" class="filter-tab {{ $selectedType === 'masterclass' ? 'active' : '' }}">Masterclass</a>
                    <a href="?type=conference" class="filter-tab {{ $selectedType === 'conference' ? 'active' : '' }}">Conférences</a>
                    <a href="?type=formation" class="filter-tab {{ $selectedType === 'formation' ? 'active' : '' }}">Formations</a>
                    <a href="?type=atelier" class="filter-tab {{ $selectedType === 'atelier' ? 'active' : '' }}">Ateliers</a>
                </div>

                <!-- Status Filters -->
                <div class="filter-tags">
                    <a href="?status=all" class="filter-tag {{ $selectedStatus === 'all' ? 'active' : '' }}">Tous</a>
                    <a href="?status=upcoming" class="filter-tag {{ $selectedStatus === 'upcoming' ? 'active' : '' }}">À venir</a>
                    <a href="?status=live" class="filter-tag {{ $selectedStatus === 'live' ? 'active' : '' }}">En direct</a>
                    <a href="?status=replay" class="filter-tag {{ $selectedStatus === 'replay' ? 'active' : '' }}">Replay</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="events-section">
        <div class="container">
            <h2 class="section-title">
                <span class="title-dot"></span>
                Événements à Venir
            </h2>

            @if($events->isEmpty())
                <div class="empty-state">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <h3>Aucun événement trouvé</h3>
                    <p>Consultez régulièrement cette page pour découvrir nos prochains événements.</p>
                </div>
            @else
                <div class="events-grid">
                    @foreach($events as $event)
                        <article class="event-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="event-image">
                                <img src="{{ $event->image }}" alt="{{ $event->title }}">
{{--
                                <img
                                    src="{{ asset('storage/' . $event->image) }}"
                                    alt="{{ $event->title }}"
                                    loading="lazy"
                                > --}}
{{--
                                <img
                                    src="{{ route('events.image', basename($event->image)) }}"
                                    alt="{{ $event->title }}"
                                    class="project-image"
                                > --}}

                                <!-- Badges -->
                                {{-- <div class="event-badges">
                                    <span class="badge badge-{{ $event->type }}">{{ ucfirst($event->type) }}</span>
                                    <span class="badge badge-status">À venir</span>
                                    @if($event->is_free)
                                        <span class="badge badge-free">GRATUIT</span>
                                    @else
                                        <span class="badge badge-price">{{ number_format($event->price, 0, ',', ' ') }} FCFA</span>
                                    @endif
                                </div>

                                <!-- Date Badge -->
                                <div class="event-date-badge">
                                    <div class="date-day">{{ $event->event_date->format('d') }}</div>
                                    <div class="date-month">{{ strtoupper($event->event_date->translatedFormat('M. Y')) }}</div>
                                </div>
                            </div>

                            <div class="event-content">
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <p class="event-description">{{ Str::limit($event->description, 120) }}</p>

                                <div class="event-meta">
                                    <div class="meta-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <span>{{ $event->event_date->format('H:i') }} • {{ $event->duration }}</span>
                                    </div>

                                    <div class="meta-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        <span>{{ $event->location }}</span>
                                    </div>

                                    @if($event->max_participants)
                                        <div class="meta-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                            <span>{{ $event->available_slots }} places restantes</span>
                                        </div>
                                    @endif
                                </div>

                                @if($event->features)
                                    <div class="event-features">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        <span>{{ $event->features }}</span>
                                    </div>
                                @endif

                                <a href="{{ route('events.show', $event->slug) }}" class="event-btn">
                                    S'inscrire
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Info Sections -->
    <section class="info-section">
        <div class="container">
            <div class="info-grid">
                <div class="info-card" data-aos="fade-up">
                    <div class="info-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3 class="info-title">Webinaires Gratuits</h3>
                    <p class="info-description">
                        Participez gratuitement à mes webinaires et découvrez de nouvelles compétences en développement web et IA.
                    </p>
                </div>

                <div class="info-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <h3 class="info-title">Accompagnement Personnalisé</h3>
                    <p class="info-description">
                        Après chaque webinaire, profitez d'un accompagnement payant pour approfondir vos connaissances.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    --accent-color: #ec4899;
    --success-color: #10b981;
    --dark-bg: #0f172a;
    --card-bg: #1e293b;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border-color: #334155;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: var(--dark-bg);
    color: var(--text-primary);
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Hero Section */
.events-hero {
    padding: 80px 0 60px;
    /* background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); */
    background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
    position: relative;
    overflow: hidden;
}

.events-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background:
        radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
    pointer-events: none; */

    background:
        radial-gradient(circle at 20% 50%, rgba(108, 92, 231, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(0, 184, 169, 0.15) 0%, transparent 50%);
    animation: gradient-shift 15s ease infinite;
    background-size: 200% 200%;
}

.hero-content {
    text-align: center;
    position: relative;
    z-index: 1;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 24px;
    color: var(--primary-color);
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 24px;
}

.hero-title {
    font-size: 56px;
    font-weight: 800;
    background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 16px;
    line-height: 1.2;
}

.hero-description {
    font-size: 20px;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}

/* Filters Section */
.events-filters {
    padding: 40px 0;
    background: var(--dark-bg);
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(12px);
}

.filters-wrapper {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Search */
.search-container {
    position: relative;
    max-width: 600px;
    width: 100%;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    stroke-width: 2;
}

.search-input {
    width: 100%;
    padding: 14px 16px 14px 48px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    color: var(--text-primary);
    font-size: 15px;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Filter Tabs */
.filter-tabs {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding-bottom: 4px;
}

.filter-tab {
    padding: 10px 20px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.filter-tab:hover {
    background: rgba(99, 102, 241, 0.1);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.filter-tab.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

/* Filter Tags */
.filter-tags {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.filter-tag {
    padding: 6px 14px;
    background: transparent;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.filter-tag:hover {
    border-color: var(--secondary-color);
    color: var(--secondary-color);
}

.filter-tag.active {
    background: var(--secondary-color);
    border-color: var(--secondary-color);
    color: white;
}

/* Events Section */
.events-section {
    padding: 60px 0 80px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 40px;
}

.title-dot {
    width: 8px;
    height: 8px;
    background: var(--primary-color);
    border-radius: 50%;
}

/* Events Grid */
.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 32px;
}

/* Event Card */
.event-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.event-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    border-color: var(--primary-color);
}

.event-image {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.event-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.event-card:hover .event-image img {
    transform: scale(1.1);
}

.event-badges {
    position: absolute;
    top: 16px;
    left: 16px;
    right: 16px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.badge {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    backdrop-filter: blur(8px);
}

.badge-webinaire {
    background: rgba(59, 130, 246, 0.9);
    color: white;
}

.badge-masterclass {
    background: rgba(139, 92, 246, 0.9);
    color: white;
}

.badge-conference {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.badge-formation {
    background: rgba(245, 158, 11, 0.9);
    color: white;
}

.badge-atelier {
    background: rgba(236, 72, 153, 0.9);
    color: white;
}

.badge-status {
    background: rgba(100, 116, 139, 0.9);
    color: white;
}

.badge-free {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.badge-price {
    background: rgba(245, 158, 11, 0.9);
    color: white;
}

.event-date-badge {
    position: absolute;
    bottom: 16px;
    right: 16px;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 12px 16px;
    text-align: center;
    min-width: 80px;
}

.date-day {
    font-size: 32px;
    font-weight: 800;
    line-height: 1;
    color: var(--primary-color);
}

.date-month {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-top: 4px;
}

.event-content {
    padding: 24px;
}

.event-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text-primary);
    line-height: 1.3;
}

.event-description {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 20px;
    line-height: 1.6;
}

.event-meta {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 16px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-secondary);
}

.meta-item svg {
    stroke-width: 2;
    color: var(--primary-color);
}

.event-features {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 12px;
    background: rgba(99, 102, 241, 0.05);
    border-left: 3px solid var(--primary-color);
    border-radius: 6px;
    margin-bottom: 20px;
}

.event-features svg {
    flex-shrink: 0;
    margin-top: 2px;
    color: var(--primary-color);
    stroke-width: 2.5;
}

.event-features span {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.5;
}

.event-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 24px;
    background: var(--primary-color);
    color: white;
    font-size: 15px;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid var(--primary-color);
}

.event-btn:hover {
    background: transparent;
    color: var(--primary-color);
    transform: translateX(4px);
}

.event-btn svg {
    transition: transform 0.3s ease;
    stroke-width: 2.5;
}

.event-btn:hover svg {
    transform: translateX(4px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-state svg {
    stroke-width: 1.5;
    color: var(--text-secondary);
    margin-bottom: 24px;
}

.empty-state h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text-primary);
}

.empty-state p {
    font-size: 16px;
    color: var(--text-secondary);
    max-width: 400px;
    margin: 0 auto;
}

/* Info Section */
.info-section {
    padding: 80px 0;
    background: linear-gradient(180deg, var(--dark-bg) 0%, #1e293b 100%);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 32px;
}

.info-card {
    padding: 40px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    text-align: center;
    transition: all 0.4s ease;
}

.info-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary-color);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.info-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
}

.info-icon svg {
    stroke-width: 2;
    color: white;
}

.info-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text-primary);
}

.info-description {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.7;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 36px;
    }

    .hero-description {
        font-size: 16px;
    }

    .events-grid {
        grid-template-columns: 1fr;
    }

    .filter-tabs {
        flex-wrap: wrap;
    }

    .filters-wrapper {
        gap: 16px;
    }
}
</style>

<script>
// Simple search functionality
document.getElementById('eventSearch')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.event-card');

    cards.forEach(card => {
        const title = card.querySelector('.event-title').textContent.toLowerCase();
        const description = card.querySelector('.event-description').textContent.toLowerCase();

        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection --}}


{{-- @extends('layouts.app_layout')

@section('title', 'Événements - Charlie DevLab')

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
        border-color: var(--secondary);
        background: rgba(0, 184, 169, 0.1);
        color: var(--secondary);
    }

    .filter-btn.active {
        background: var(--secondary);
        color: white;
    }

    .events-section {
        padding: 4rem 2rem;
        background: var(--dark-bg);
    }

    .events-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .events-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .event-card {
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

    .event-card:hover {
        transform: translateY(-10px);
        border-color: var(--secondary);
        box-shadow: 0 20px 40px rgba(0, 184, 169, 0.2);
    }

    .event-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        position: relative;
    }

    .event-date-badge {
        background: white;
        color: var(--primary);
        width: 70px;
        height: 70px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .event-day {
        font-size: 2rem;
        line-height: 1;
    }

    .event-month {
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-top: 0.2rem;
    }

    .event-type-badges {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .event-type-badge {
        padding: 0.4rem 0.8rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        text-transform: uppercase;
    }

    .event-price-badge {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        padding: 0.5rem 1rem;
        background: var(--warning);
        color: white;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .event-price-badge.free {
        background: var(--success);
    }

    .event-body {
        padding: 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .event-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .event-description {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .event-meta-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .event-meta-icon {
        width: 30px;
        height: 30px;
        background: var(--dark-bg);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--dark-border);
    }

    .event-view-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--secondary), #00E5D0);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        display: block;
        text-decoration: none;
    }

    .event-view-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 184, 169, 0.3);
    }

    .past-event {
        opacity: 0.6;
    }

    .past-event .event-view-btn {
        background: var(--dark-bg);
        color: var(--text-secondary);
    }

    @media (max-width: 1024px) {
        .events-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .page-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .events-grid {
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
        <div class="page-subtitle">ÉVÉNEMENTS</div>
        <h1 class="page-title">Webinaires & Masterclass</h1>
        <p class="page-description">
            Participez à mes événements en ligne pour apprendre et échanger sur le développement web.
        </p>
    </div>
</section>

<section class="filters-section">
    <div class="filters-container">
        @foreach($types as $type)
            <a
                href="{{ route('events.index', ['type' => $type]) }}"
                class="filter-btn {{ (!request('type') && $type == 'all') || request('type') == $type ? 'active' : '' }}"
            >
                {{ $type == 'all' ? 'Tous' : ucfirst($type) }}
            </a>
        @endforeach
    </div>
</section>

<section class="events-section">
    <div class="events-container">
        @if($events->count() > 0)
            <div class="events-grid">
                @foreach($events as $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="event-card {{ $event->event_date->isPast() ? 'past-event' : '' }}">
                        <div class="event-header">
                            <div class="event-date-badge">
                                <span class="event-day">{{ $event->event_date->format('d') }}</span>
                                <span class="event-month">{{ $event->event_date->format('M') }}</span>
                            </div>

                            <div class="event-type-badges">
                                <span class="event-type-badge">{{ $event->type }}</span>
                                @if($event->location == 'En ligne')
                                    <span class="event-type-badge">📡 En ligne</span>
                                @endif
                            </div>

                            @if($event->is_free)
                                <span class="event-price-badge free">GRATUIT</span>
                            @else
                                <span class="event-price-badge">{{ number_format($event->price, 0, ',', ' ') }} FCFA</span>
                            @endif
                        </div>

                        <div class="event-body">
                            <h3 class="event-title">{{ $event->title }}</h3>
                            <p class="event-description">{{ Str::limit($event->description, 120) }}</p>

                            <div class="event-meta">
                                <div class="event-meta-item">
                                    <span class="event-meta-icon">🕐</span>
                                    {{ $event->event_date->format('d/m/Y à H:i') }} • {{ $event->duration }}
                                </div>
                                <div class="event-meta-item">
                                    <span class="event-meta-icon">📍</span>
                                    {{ $event->location }}
                                </div>
                                <div class="event-meta-item">
                                    <span class="event-meta-icon">👥</span>
                                    @if($event->max_participants)
                                        {{ $event->available_slots }} places restantes
                                    @else
                                        Places illimitées
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="event-footer">
                            @if($event->event_date->isPast())
                                <span class="event-view-btn">Événement terminé</span>
                            @else
                                <span class="event-view-btn">Voir les détails</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pagination-wrapper" style="margin-top: 3rem;">
                {{ $events->links() }}
            </div>
        @else
            <div class="empty-state" style="text-align: center; padding: 6rem 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.8rem; color: var(--text-primary);">Aucun événement prévu</h3>
                <p style="color: var(--text-secondary); font-size: 1.1rem;">Revenez bientôt pour découvrir nos prochains événements.</p>
            </div>
        @endif
    </div>
</section>
@endsection --}}


{{-- @extends('layouts.app_layout')

@section('content')
<div class="container py-5">
    <h2 class="text-white mb-4 fw-bold">📅 Nos événements à venir</h2>

    <div class="row g-4">
        @foreach($events as $event)
        <div class="col-md-6 col-lg-4">
            <div class="event-card">

                {{-- IMAGE --}}
                {{-- <div class="event-image"
                     style="background-image:url('{{ asset('storage/'.$event->image) }}')">

                    <div class="event-tags">
                        <span class="tag type">{{ ucfirst($event->type) }}</span>
                        <span class="tag status">À venir</span>
                    </div>

                    <div class="event-price">
                        {{ $event->is_free ? 'GRATUIT' : number_format($event->price, 0, ',', ' ') . ' FCFA' }}
                    </div>
                </div> --}}

                {{-- CONTENT --}}
                {{-- <div class="event-body">
                    <div class="event-date">
                        <span class="day">{{ $event->event_date->format('d') }}</span>
                        <span class="month">{{ strtoupper($event->event_date->translatedFormat('M')) }}</span>
                        <span class="year">{{ $event->event_date->format('Y') }}</span>
                    </div>

                    <h5 class="event-title">{{ $event->title }}</h5>
                    <p class="event-desc">{{ Str::limit($event->description, 120) }}</p>

                    <ul class="event-info">
                        <li>⏰ {{ $event->event_date->format('H:i') }} • {{ $event->duration }}</li>
                        <li>🌐 {{ $event->location }}</li>
                        @if($event->max_participants)
                            <li>👥 {{ $event->available_slots }} places restantes</li>
                        @endif
                    </ul>

                    @if($event->features)
                    <div class="event-feature">
                        ⚡ {{ $event->features }}
                    </div>
                    @endif

                    <a href="{{ route('events.show', $event->slug) }}" class="btn btn-event">
                        S'inscrire →
                    </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection --}}
