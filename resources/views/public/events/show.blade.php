
@extends('layouts.app_layout')

@section('content')
<div class="event-detail-page">
    <!-- Hero Section avec Image -->
    <section class="event-hero">
        <div class="hero-image" style="background-image: url('{{ $event->image }}');"></div>
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <a href="{{ route('events.index') }}" class="back-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Retour aux événements
                </a>

                <div class="hero-badges">
                    <span class="badge badge-{{ $event->type }}">{{ ucfirst($event->type) }}</span>
                    @if($event->event_date > now())
                        <span class="badge badge-upcoming">À venir</span>
                    @elseif($event->event_date > now()->subHours(3))
                        <span class="badge badge-live">
                            <span class="live-dot"></span>
                            En direct
                        </span>
                    @else
                        <span class="badge badge-past">Terminé</span>
                    @endif
                    @if($event->is_featured)
                        <span class="badge badge-featured">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                            En vedette
                        </span>
                    @endif
                </div>

                <h1 class="hero-title">{{ $event->title }}</h1>

                <div class="hero-meta">
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>{{ $event->event_date->translatedFormat('l d F Y à H:i') }}</span>
                    </div>

                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>{{ $event->duration }}</span>
                    </div>

                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="event-content-section">
        <div class="container">
            <div class="content-grid">
                <!-- Left Column -->
                <div class="main-content">
                    <!-- Description -->
                    <div class="content-block" data-aos="fade-up">
                        <div class="block-header">
                            <div class="block-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </div>
                            <h2 class="block-title">À propos de cet événement</h2>
                        </div>
                        <div class="block-content">
                            <p>{{ $event->description }}</p>
                        </div>
                    </div>

                    @if($event->features)
                        <div class="content-block" data-aos="fade-up" data-aos-delay="100">
                            <div class="block-header">
                                <div class="block-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <h2 class="block-title">Ce que vous allez apprendre</h2>
                            </div>
                            <div class="features-list">
                                @foreach(explode("\n", $event->features) as $feature)
                                    @if(trim($feature))
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </div>
                                            <span>{{ trim($feature) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Programme -->
                    <div class="content-block" data-aos="fade-up" data-aos-delay="200">
                        <div class="block-header">
                            <div class="block-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M12 2v20M2 12h20"></path>
                                </svg>
                            </div>
                            <h2 class="block-title">Programme de l'événement</h2>
                        </div>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Introduction & Bienvenue</h4>
                                    <p>Présentation du sujet, des objectifs et tour de table des participants</p>
                                    <span class="timeline-time">15 min</span>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Contenu Principal</h4>
                                    <p>Développement des concepts clés avec démonstrations et exemples pratiques</p>
                                    <span class="timeline-time">45 min</span>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Session Pratique</h4>
                                    <p>Exercices en direct et mise en application des connaissances</p>
                                    <span class="timeline-time">30 min</span>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Questions & Réponses</h4>
                                    <p>Session interactive avec les participants, échanges et conseils</p>
                                    <span class="timeline-time">20 min</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Info -->
                    <div class="content-block instructor-block" data-aos="fade-up" data-aos-delay="300">
                        <div class="block-header">
                            <div class="block-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <h2 class="block-title">Votre formateur</h2>
                        </div>
                        <div class="instructor-content">
                            <div class="instructor-avatar">
                                <img src="{{ asset('images/profile.jpg') }}" alt="Charlie DevLab">
                            </div>
                            <div class="instructor-info">
                                <h3>Charlie DevLab</h3>
                                <p class="instructor-role">Développeur Fullstack & Formateur</p>
                                <p class="instructor-bio">
                                    Passionné par le développement web et l'intelligence artificielle, je partage mes connaissances à travers des formations pratiques et accessibles.
                                </p>
                                <div class="instructor-social">
                                    <a href="#" class="social-link">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                            <rect x="2" y="9" width="4" height="12"></rect>
                                            <circle cx="4" cy="4" r="2"></circle>
                                        </svg>
                                    </a>
                                    <a href="#" class="social-link">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="social-link">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="sidebar">
                    <!-- Registration Card -->
                    <div class="registration-card" data-aos="fade-up">
                        <div class="card-header">
                            @if($event->is_free)
                                <div class="price free">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                    <span>GRATUIT</span>
                                </div>
                            @else
                                <div class="price">
                                    <span class="price-amount">{{ number_format($event->price, 0, ',', ' ') }}</span>
                                    <span class="price-currency">FCFA</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            @if($event->max_participants)
                                <div class="availability">
                                    <div class="availability-info">
                                        <span class="availability-label">Places disponibles</span>
                                        <span class="availability-count">{{ $event->available_slots }} / {{ $event->max_participants }}</span>
                                    </div>
                                    <div class="availability-bar">
                                        <div class="availability-fill" style="width: {{ ($event->registered_count / $event->max_participants) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-error">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            @if($isRegistered)
                                <div class="registered-status">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                    <span>Vous êtes inscrit !</span>
                                </div>

                                <form action="{{ route('events.cancel', $event->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Êtes-vous sûr de vouloir annuler votre inscription ?')">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                        Annuler l'inscription
                                    </button>
                                </form>
                            @else
                                @if($event->hasAvailableSlots())
                                    <form action="{{ route('events.register', $event->slug) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="8.5" cy="7" r="4"></circle>
                                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                                <line x1="23" y1="11" x2="17" y2="11"></line>
                                            </svg>
                                            S'inscrire maintenant
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-disabled" disabled>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                        Complet
                                    </button>
                                @endif
                            @endif
                        </div>

                        @if($event->features)
                            <div class="card-footer">
                                <div class="footer-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M12 2v20M2 12h20"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4>Accompagnement disponible</h4>
                                    <p>Profitez d'un suivi personnalisé après cet événement</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Event Info Card -->
                    <div class="info-card" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="info-title">Informations pratiques</h3>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div>
                                <strong>Date & Heure</strong>
                                <p>{{ $event->event_date->translatedFormat('l d F Y') }}<br>à {{ $event->event_date->format('H:i') }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div>
                                <strong>Durée</strong>
                                <p>{{ $event->duration }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <strong>Lieu</strong>
                                <p>{{ $event->location }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <div>
                                <strong>Participants</strong>
                                <p>{{ $event->registered_count }} inscrit(s)
                                @if($event->max_participants)
                                    / {{ $event->max_participants }} max
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Share Card -->
                    <div class="share-card" data-aos="fade-up" data-aos-delay="200">
                        <h4>Partager cet événement</h4>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('events.show', $event->slug)) }}" target="_blank" class="share-btn share-facebook" title="Partager sur Facebook">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('events.show', $event->slug)) }}&text={{ urlencode($event->title) }}" target="_blank" class="share-btn share-twitter" title="Partager sur Twitter">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('events.show', $event->slug)) }}" target="_blank" class="share-btn share-linkedin" title="Partager sur LinkedIn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                    <rect x="2" y="9" width="4" height="12"></rect>
                                    <circle cx="4" cy="4" r="2"></circle>
                                </svg>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . route('events.show', $event->slug)) }}" target="_blank" class="share-btn share-whatsapp" title="Partager sur WhatsApp">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Events -->
    @if($relatedEvents->isNotEmpty())
        <section class="related-events">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <h2 class="section-title">
                        <span class="title-dot"></span>
                        Événements similaires
                    </h2>
                    <p class="section-subtitle">Découvrez d'autres événements qui pourraient vous intéresser</p>
                </div>

                <div class="related-grid">
                    @foreach($relatedEvents as $relatedEvent)
                        <article class="related-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="related-image">
                                <img src="{{ $relatedEvent->image }}" alt="{{ $relatedEvent->title }}" loading="lazy">
                                <div class="related-overlay"></div>
                                <span class="related-badge">{{ ucfirst($relatedEvent->type) }}</span>
                                <div class="related-date">
                                    <span class="date-day">{{ $relatedEvent->event_date->format('d') }}</span>
                                    <span class="date-month">{{ strtoupper($relatedEvent->event_date->translatedFormat('M')) }}</span>
                                </div>
                            </div>
                            <div class="related-content">
                                <h3>{{ Str::limit($relatedEvent->title, 60) }}</h3>
                                <p class="related-meta">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ $relatedEvent->event_date->translatedFormat('d F Y') }} • {{ $relatedEvent->duration }}
                                </p>
                                <a href="{{ route('events.show', $relatedEvent->slug) }}" class="related-link">
                                    Voir l'événement
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
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

.event-detail-page {
    background: var(--dark-bg);
    min-height: 100vh;
}

/* Event Hero */
.event-hero {
    position: relative;
    min-height: 500px;
    display: flex;
    align-items: flex-end;
    padding: 80px 0 60px;
    overflow: hidden;
}

.hero-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.95));
}

.hero-content {
    position: relative;
    z-index: 1;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-bottom: 24px;
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-4px);
}

.back-btn svg {
    stroke-width: 2;
}

.hero-badges {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.badge {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.badge-webinaire { background: #3b82f6; color: white; }
.badge-masterclass { background: #8b5cf6; color: white; }
.badge-conference { background: #10b981; color: white; }
.badge-formation { background: #f59e0b; color: white; }
.badge-atelier { background: #ec4899; color: white; }
.badge-upcoming { background: rgba(100, 116, 139, 0.9); color: white; }
.badge-past { background: rgba(100, 116, 139, 0.9); color: white; }

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

.badge-featured {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.hero-title {
    font-size: 48px;
    font-weight: 800;
    color: white;
    margin-bottom: 24px;
    line-height: 1.2;
}

.hero-meta {
    display: flex;
    gap: 32px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 15px;
}

.meta-item svg {
    stroke-width: 2;
    color: var(--primary);
}

/* Content Section */
.event-content-section {
    padding: 80px 0;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 40px;
}

.content-block {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 24px;
    transition: all 0.3s ease;
}

.content-block:hover {
    border-color: var(--primary);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.block-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}

.block-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 12px;
    flex-shrink: 0;
}

.block-icon svg {
    stroke-width: 2;
    color: white;
}

.block-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
}

.block-content {
    font-size: 16px;
    line-height: 1.8;
    color: var(--text-secondary);
}

/* Features List */
.features-list {
    display: grid;
    gap: 16px;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 16px;
    background: rgba(99, 102, 241, 0.05);
    border-left: 3px solid var(--success);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: rgba(99, 102, 241, 0.1);
    transform: translateX(4px);
}

.feature-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--success);
    border-radius: 8px;
    flex-shrink: 0;
}

.feature-icon svg {
    stroke-width: 2.5;
    color: white;
}

.feature-item span {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 40px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 12px;
    bottom: 12px;
    width: 2px;
    background: var(--border);
}

.timeline-item {
    position: relative;
    margin-bottom: 32px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -34px;
    top: 4px;
    width: 16px;
    height: 16px;
    background: var(--primary);
    border: 3px solid var(--card-bg);
    border-radius: 50%;
    z-index: 1;
}

.timeline-content h4 {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.timeline-content p {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 8px;
}

.timeline-time {
    display: inline-block;
    padding: 4px 12px;
    background: rgba(99, 102, 241, 0.1);
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    color: var(--primary);
}

/* Instructor Block */
.instructor-block {
    background: linear-gradient(135deg, var(--card-bg), #1a2332);
}

.instructor-content {
    display: flex;
    gap: 24px;
}

.instructor-avatar {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    overflow: hidden;
    flex-shrink: 0;
    border: 3px solid var(--primary);
}

.instructor-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.instructor-info h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.instructor-role {
    font-size: 14px;
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 12px;
}

.instructor-bio {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 16px;
}

.instructor-social {
    display: flex;
    gap: 12px;
}

.social-link {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--primary);
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
    transform: translateY(-2px);
}

/* Registration Card */
.registration-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    position: sticky;
    top: 100px;
}

.card-header {
    padding: 32px 24px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    text-align: center;
}

.price {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.price.free {
    flex-direction: row;
    justify-content: center;
    gap: 12px;
}

.price.free svg {
    stroke-width: 2;
    color: white;
}

.price.free span {
    font-size: 32px;
    font-weight: 800;
    color: white;
}

.price-amount {
    font-size: 48px;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.price-currency {
    font-size: 16px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.8);
}

.card-body {
    padding: 24px;
}

.availability {
    margin-bottom: 24px;
}

.availability-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.availability-label {
    font-size: 14px;
    color: var(--text-secondary);
    font-weight: 500;
}

.availability-count {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary);
}

.availability-bar {
    height: 8px;
    background: var(--border);
    border-radius: 4px;
    overflow: hidden;
}

.availability-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--success), var(--primary));
    transition: width 0.3s ease;
}

.alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert svg {
    stroke-width: 2.5;
    flex-shrink: 0;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: var(--success);
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #ef4444;
}

.registered-status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 20px;
    background: rgba(16, 185, 129, 0.1);
    border: 2px solid var(--success);
    border-radius: 12px;
    color: var(--success);
    font-weight: 600;
    margin-bottom: 16px;
}

.registered-status svg {
    stroke-width: 2.5;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 24px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn svg {
    stroke-width: 2;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--secondary);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
}

.btn-secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 2px solid var(--border);
}

.btn-secondary:hover {
    border-color: #ef4444;
    color: #ef4444;
    background: rgba(239, 68, 68, 0.05);
}

.btn-disabled {
    background: var(--border);
    color: var(--text-secondary);
    cursor: not-allowed;
}

.card-footer {
    display: flex;
    gap: 16px;
    padding: 24px;
    background: rgba(99, 102, 241, 0.05);
    border-top: 1px solid var(--border);
}

.footer-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary);
    border-radius: 10px;
    flex-shrink: 0;
}

.footer-icon svg {
    stroke-width: 2;
    color: white;
}

.card-footer h4 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.card-footer p {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.5;
}

/* Info Card */
.info-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
}

.info-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 20px;
}

.info-item {
    display: flex;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid var(--border);
}

.info-item:last-child {
    border-bottom: none;
}

.info-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(99, 102, 241, 0.1);
    border-radius: 10px;
    flex-shrink: 0;
}

.info-icon svg {
    stroke-width: 2;
    color: var(--primary);
}

.info-item strong {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.info-item p {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Share Card */
.share-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
}

.share-card h4 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 16px;
}

.share-buttons {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

.share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    aspect-ratio: 1;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.share-btn svg {
    width: 20px;
    height: 20px;
}

.share-facebook { background: #1877f2; color: white; }
.share-twitter { background: #1da1f2; color: white; }
.share-linkedin { background: #0a66c2; color: white; }
.share-whatsapp { background: #25d366; color: white; }

.share-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

/* Related Events */
.related-events {
    padding: 80px 0;
    background: linear-gradient(180deg, var(--dark-bg) 0%, #1e293b 100%);
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

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 32px;
}

.related-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s ease;
}

.related-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.related-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.related-card:hover .related-image img {
    transform: scale(1.1);
}

.related-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent, rgba(15, 23, 42, 0.7));
}

.related-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 6px 12px;
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(8px);
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    z-index: 2;
}

.related-date {
    position: absolute;
    bottom: 16px;
    right: 16px;
    padding: 8px 12px;
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(8px);
    border-radius: 8px;
    text-align: center;
    z-index: 2;
}

.date-day {
    display: block;
    font-size: 20px;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
}

.date-month {
    display: block;
    font-size: 10px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-top: 2px;
}

.related-content {
    padding: 24px;
}

.related-content h3 {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 12px;
    line-height: 1.4;
}

.related-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: 16px;
}

.related-meta svg {
    stroke-width: 2;
}

.related-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.related-link:hover {
    gap: 12px;
}

.related-link svg {
    stroke-width: 2.5;
}

/* Responsive */
@media (max-width: 992px) {
    .content-grid {
        grid-template-columns: 1fr;
    }

    .registration-card {
        position: static;
    }

    .hero-title {
        font-size: 32px;
    }

    .hero-meta {
        flex-direction: column;
        gap: 16px;
    }

    .instructor-content {
        flex-direction: column;
    }
}

@media (max-width: 768px) {
    .share-buttons {
        grid-template-columns: repeat(2, 1fr);
    }

    .related-grid {
        grid-template-columns: 1fr;
    }

    .section-title {
        font-size: 24px;
    }
}
</style>
@endsection

{{-- @extends('layouts.app_layout')

@section('content')
<div class="event-detail-page">
    <!-- Hero Section avec Image -->
    <section class="event-hero" style="background-image: url('{{ $event->image }}');">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <a href="{{ route('events.index') }}" class="back-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Retour aux événements
                </a>

                <div class="hero-badges">
                    <span class="badge badge-{{ $event->type }}">{{ ucfirst($event->type) }}</span>
                    @if($event->is_free)
                        <span class="badge badge-free">GRATUIT</span>
                    @else
                        <span class="badge badge-price">{{ number_format($event->price, 0, ',', ' ') }} FCFA</span>
                    @endif
                    @if($event->is_featured)
                        <span class="badge badge-featured">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                            En vedette
                        </span>
                    @endif
                </div>

                <h1 class="hero-title">{{ $event->title }}</h1>

                <div class="hero-meta">
                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>{{ $event->event_date->translatedFormat('l d F Y à H:i') }}</span>
                    </div>

                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>{{ $event->duration }}</span>
                    </div>

                    <div class="meta-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="event-content-section">
        <div class="container">
            <div class="content-grid">
                <!-- Left Column -->
                <div class="main-content">
                    <!-- Description -->
                    <div class="content-block">
                        <h2 class="block-title">À propos de cet événement</h2>
                        <div class="block-content">
                            {{ $event->description }}
                        </div>
                    </div>

                    @if($event->features)
                        <div class="content-block">
                            <h2 class="block-title">Ce que vous allez apprendre</h2>
                            <div class="features-list">
                                @foreach(explode("\n", $event->features) as $feature)
                                    @if(trim($feature))
                                        <div class="feature-item">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span>{{ trim($feature) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Programme (si disponible) -->
                    <div class="content-block">
                        <h2 class="block-title">Programme</h2>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Introduction</h4>
                                    <p>Présentation du sujet et des objectifs</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Contenu Principal</h4>
                                    <p>Développement des concepts clés avec exemples pratiques</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Questions & Réponses</h4>
                                    <p>Session interactive avec les participants</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="sidebar">
                    <!-- Registration Card -->
                    <div class="registration-card">
                        <div class="card-header">
                            @if($event->is_free)
                                <div class="price free">GRATUIT</div>
                            @else
                                <div class="price">{{ number_format($event->price, 0, ',', ' ') }} <span class="currency">FCFA</span></div>
                            @endif
                        </div>

                        <div class="card-body">
                            @if($event->max_participants)
                                <div class="availability">
                                    <div class="availability-bar">
                                        <div class="availability-fill" style="width: {{ ($event->registered_count / $event->max_participants) * 100 }}%"></div>
                                    </div>
                                    <p class="availability-text">
                                        <strong>{{ $event->available_slots }}</strong> place(s) restante(s) sur <strong>{{ $event->max_participants }}</strong>
                                    </p>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-error">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($isRegistered)
                                <div class="registered-status">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                    <span>Vous êtes inscrit</span>
                                </div>

                                <form action="{{ route('events.cancel', $event->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Êtes-vous sûr de vouloir annuler votre inscription ?')">
                                        Annuler l'inscription
                                    </button>
                                </form>
                            @else
                                @if($event->hasAvailableSlots())
                                    <form action="{{ route('events.register', $event->slug) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="8.5" cy="7" r="4"></circle>
                                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                                <line x1="23" y1="11" x2="17" y2="11"></line>
                                            </svg>
                                            S'inscrire maintenant
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-disabled" disabled>
                                        Complet
                                    </button>
                                @endif
                            @endif
                        </div>

                        @if($event->features)
                            <div class="card-footer">
                                <h4>Accompagnement personnalisé disponible</h4>
                                <p>{{ $event->features }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Event Info Card -->
                    <div class="info-card">
                        <h3 class="info-title">Informations pratiques</h3>

                        <div class="info-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <div>
                                <strong>Date & Heure</strong>
                                <p>{{ $event->event_date->translatedFormat('l d F Y') }}<br>à {{ $event->event_date->format('H:i') }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <div>
                                <strong>Durée</strong>
                                <p>{{ $event->duration }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <div>
                                <strong>Lieu</strong>
                                <p>{{ $event->location }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <div>
                                <strong>Participants</strong>
                                <p>{{ $event->registered_count }} inscrits
                                @if($event->max_participants)
                                    / {{ $event->max_participants }} max
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Share Card -->
                    <div class="share-card">
                        <h4>Partager cet événement</h4>
                        <div class="share-buttons">
                            <a href="#" class="share-btn share-facebook">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                            <a href="#" class="share-btn share-twitter">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                </svg>
                            </a>
                            <a href="#" class="share-btn share-linkedin">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                    <rect x="2" y="9" width="4" height="12"></rect>
                                    <circle cx="4" cy="4" r="2"></circle>
                                </svg>
                            </a>
                            <a href="#" class="share-btn share-whatsapp">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Events -->
    @if($relatedEvents->isNotEmpty())
        <section class="related-events">
            <div class="container">
                <h2 class="section-title">
                    <span class="title-dot"></span>
                    Événements similaires
                </h2>

                <div class="related-grid">
                    @foreach($relatedEvents as $relatedEvent)
                        <article class="related-card">
                            <div class="related-image">
                                <img src="{{ $relatedEvent->image }}" alt="{{ $relatedEvent->title }}">
                                <span class="related-badge">{{ ucfirst($relatedEvent->type) }}</span>
                            </div>
                            <div class="related-content">
                                <h3>{{ $relatedEvent->title }}</h3>
                                <p class="related-date">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ $relatedEvent->event_date->translatedFormat('d F Y') }}
                                </p>
                                <a href="{{ route('events.show', $relatedEvent->slug) }}" class="related-link">
                                    Voir l'événement
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
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

.event-detail-page {
    background: var(--dark-bg);
    min-height: 100vh;
}

/* Event Hero */
.event-hero {
    position: relative;
    min-height: 500px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-end;
    padding: 60px 0;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.95));
}

.hero-content {
    position: relative;
    z-index: 1;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-bottom: 24px;
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-4px);
}

.hero-badges {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.badge {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.badge-webinaire { background: #3b82f6; color: white; }
.badge-masterclass { background: #8b5cf6; color: white; }
.badge-conference { background: #10b981; color: white; }
.badge-formation { background: #f59e0b; color: white; }
.badge-atelier { background: #ec4899; color: white; }
.badge-free { background: #10b981; color: white; }
.badge-price { background: #f59e0b; color: white; }
.badge-featured {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
}

.hero-title {
    font-size: 48px;
    font-weight: 800;
    color: white;
    margin-bottom: 24px;
    line-height: 1.2;
}

.hero-meta {
    display: flex;
    gap: 32px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 15px;
}

.meta-item svg {
    stroke-width: 2;
    color: var(--primary-color);
}

/* Content Section */
.event-content-section {
    padding: 60px 0;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 40px;
}

.content-block {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 24px;
}

.block-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 20px;
}

.block-content {
    font-size: 16px;
    line-height: 1.8;
    color: var(--text-secondary);
}

/* Features List */
.features-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    background: rgba(99, 102, 241, 0.05);
    border-left: 3px solid var(--primary-color);
    border-radius: 8px;
}

.feature-item svg {
    flex-shrink: 0;
    margin-top: 2px;
    stroke-width: 2.5;
    color: var(--success-color);
}

.feature-item span {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 32px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 6px;
    top: 8px;
    bottom: 8px;
    width: 2px;
    background: var(--border-color);
}

.timeline-item {
    position: relative;
    margin-bottom: 32px;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 4px;
    width: 14px;
    height: 14px;
    background: var(--primary-color);
    border: 3px solid var(--card-bg);
    border-radius: 50%;
    z-index: 1;
}

.timeline-content h4 {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.timeline-content p {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Registration Card */
.registration-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
    position: sticky;
    top: 100px;
}

.card-header {
    padding: 24px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    text-align: center;
}

.price {
    font-size: 48px;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.price.free {
    font-size: 36px;
}

.currency {
    font-size: 20px;
    font-weight: 600;
    opacity: 0.9;
}

.card-body {
    padding: 24px;
}

.availability {
    margin-bottom: 24px;
}

.availability-bar {
    height: 8px;
    background: var(--border-color);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 12px;
}

.availability-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--success-color), var(--primary-color));
    transition: width 0.3s ease;
}

.availability-text {
    font-size: 14px;
    color: var(--text-secondary);
    text-align: center;
}

.alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: var(--success-color);
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #ef4444;
}

.registered-status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 20px;
    background: rgba(16, 185, 129, 0.1);
    border: 2px solid var(--success-color);
    border-radius: 12px;
    color: var(--success-color);
    font-weight: 600;
    margin-bottom: 16px;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 24px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
}

.btn-secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
}

.btn-secondary:hover {
    border-color: #ef4444;
    color: #ef4444;
}

.btn-disabled {
    background: var(--border-color);
    color: var(--text-secondary);
    cursor: not-allowed;
}

.card-footer {
    padding: 24px;
    background: rgba(99, 102, 241, 0.05);
    border-top: 1px solid var(--border-color);
}

.card-footer h4 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.card-footer p {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.5;
}

/* Info Card */
.info-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
}

.info-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 20px;
}

.info-item {
    display: flex;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid var(--border-color);
}

.info-item:last-child {
    border-bottom: none;
}

.info-item svg {
    flex-shrink: 0;
    stroke-width: 2;
    color: var(--primary-color);
}

.info-item strong {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.info-item p {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.5;
}

/* Share Card */
.share-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 24px;
}

.share-card h4 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 16px;
}

.share-buttons {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

.share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    aspect-ratio: 1;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.share-btn svg {
    width: 20px;
    height: 20px;
}

.share-facebook {
    background: #1877f2;
    color: white;
}

.share-twitter {
    background: #1da1f2;
    color: white;
}

.share-linkedin {
    background: #0a66c2;
    color: white;
}

.share-whatsapp {
    background: #25d366;
    color: white;
}

.share-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

/* Related Events */
.related-events {
    padding: 80px 0;
    background: linear-gradient(180deg, var(--dark-bg) 0%, #1e293b 100%);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 28px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 40px;
}

.title-dot {
    width: 8px;
    height: 8px;
    background: var(--primary-color);
    border-radius: 50%;
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

.related-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.related-card:hover {
    transform: translateY(-4px);
    border-color: var(--primary-color);
}

.related-image {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 6px 12px;
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(8px);
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
}

.related-content {
    padding: 20px;
}

.related-content h3 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 12px;
    line-height: 1.4;
}

.related-date {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: 16px;
}

.related-date svg {
    stroke-width: 2;
}

.related-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--primary-color);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.related-link:hover {
    gap: 10px;
}

.related-link svg {
    stroke-width: 2.5;
}

/* Responsive */
@media (max-width: 992px) {
    .content-grid {
        grid-template-columns: 1fr;
    }

    .registration-card {
        position: static;
    }

    .hero-title {
        font-size: 32px;
    }

    .hero-meta {
        flex-direction: column;
        gap: 16px;
    }
}

@media (max-width: 768px) {
    .share-buttons {
        grid-template-columns: repeat(2, 1fr);
    }

    .related-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection --}}
