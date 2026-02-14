@extends('layouts.app_layout')

@section('title', $realisation->title . ' - Réalisations')

@push('styles')
<style>
    .project-hero {
        padding: 8rem 2rem 4rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .project-hero::before {
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

    .project-hero-content {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
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

    .project-category-badge {
        display: inline-block;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }

    .project-category-badge.web {
        background: rgba(102, 126, 234, 0.1);
        color: #667EEA;
        border: 1px solid #667EEA;
    }

    .project-category-badge.mobile {
        background: rgba(0, 212, 170, 0.1);
        color: #00D4AA;
        border: 1px solid #00D4AA;
    }

    .project-category-badge.design {
        background: rgba(255, 107, 157, 0.1);
        color: #FF6B9D;
        border: 1px solid #FF6B9D;
    }

    .project-hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .project-hero-description {
        font-size: 1.3rem;
        color: var(--text-secondary);
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .project-meta-info {
        display: flex;
        gap: 3rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .meta-label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .meta-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .project-image-section {
        padding: 4rem 2rem;
        background: var(--dark-card);
    }

    .project-image-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .main-project-image {
        width: 100%;
        height: 450px;
        border-radius: 20px;
        border: 1px solid var(--dark-border);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .project-details-section {
        padding: 4rem 2rem;
        background: var(--dark-bg);
    }

    .project-details-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 4rem;
    }

    .project-description-full {
        font-size: 1.1rem;
        line-height: 1.9;
        color: var(--text-secondary);
        margin-bottom: 3rem;
    }

    .project-technologies-section {
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
    }

    .technologies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
    }

    .technology-item {
        padding: 1rem;
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        text-align: center;
        font-weight: 600;
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .technology-item:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        transform: translateY(-3px);
    }

    .project-sidebar {
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
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .project-link-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .project-link-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.4);
    }

    .related-projects-section {
        padding: 4rem 2rem;
        background: var(--dark-card);
    }

    .related-projects-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .related-projects-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 2rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .project-details-container {
            grid-template-columns: 1fr;
        }

        .project-sidebar {
            position: static;
        }

        .related-projects-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .project-hero-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .related-projects-grid {
            grid-template-columns: 1fr;
        }

        .project-hero-title {
            font-size: 2rem;
        }

        .project-hero-description {
            font-size: 1.1rem;
        }

        .technologies-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<!-- Project Hero -->
<section class="project-hero">
    <div class="project-hero-content">
        <a href="{{ route('realisations.index') }}" class="back-link">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Retour aux réalisations
        </a>

        <span class="project-category-badge {{ strtolower($realisation->category) }}">
            {{ $realisation->category }}
        </span>

        <h1 class="project-hero-title">{{ $realisation->title }}</h1>
        <p class="project-hero-description">{{ $realisation->description }}</p>

        <div class="project-meta-info">
            <div class="meta-item">
                <span class="meta-label">Client</span>
                <span class="meta-value">{{ $realisation->client ?? 'Projet Personnel' }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Date</span>
                <span class="meta-value">{{ $realisation->completion_date->format('F Y') }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Catégorie</span>
                <span class="meta-value">{{ $realisation->category }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Project Image -->
<section class="project-image-section">
    <div class="project-image-container">
        {{-- <img src="{{ asset('storage/' . $realisation->image) }}" alt="{{ $realisation->title }}" class="main-project-image"> --}}
        <img
            src="{{ route('realisations.image', basename($realisation->image)) }}"
            alt="{{ $realisation->title }}"
            class="main-project-image"
        >
    </div>
</section>

<!-- Project Details -->
<section class="project-details-section">
    <div class="project-details-container">
        <!-- Main Content -->
        <div class="project-main-content">
            <div class="project-description-full">
                <h2 class="section-title">À propos du projet</h2>
                <p>{{ $realisation->description }}</p>
                <br>
                <p>Ce projet a été conçu pour répondre aux besoins spécifiques du client en offrant une solution moderne, performante et intuitive. L'objectif était de créer une plateforme qui combine esthétique et fonctionnalité tout en garantissant une excellente expérience utilisateur.</p>
            </div>

            <div class="project-technologies-section">
                <h2 class="section-title">Technologies utilisées</h2>
                <div class="technologies-grid">
                    @foreach($realisation->technologies as $tech)
                        <div class="technology-item">{{ $tech }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="project-sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-title">Informations du projet</h3>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Client</span>
                        <span class="info-value">{{ $realisation->client ?? 'Personnel' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de réalisation</span>
                        <span class="info-value">{{ $realisation->completion_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Catégorie</span>
                        <span class="info-value">{{ $realisation->category }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Technologies</span>
                        <span class="info-value">{{ count($realisation->technologies) }} technologies</span>
                    </div>
                </div>

                @if($realisation->project_url)
                    <a href="{{ $realisation->project_url }}" target="_blank" class="project-link-btn">
                        Voir le projet en ligne
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/>
                        </svg>
                    </a>
                @endif
            </div>
        </aside>
    </div>
</section>

<!-- Related Projects -->
@if($similarRealisations->count() > 0)
<section class="related-projects-section">
    <div class="related-projects-container">
        <h2 class="section-title">Projets similaires</h2>

        <div class="related-projects-grid">
            @foreach($similarRealisations as $similar)
                <a href="{{ route('realisations.show', $similar->slug) }}" class="project-card">
                    <div class="project-image-wrapper">
                        <img src="{{ $similar->image }}" alt="{{ $similar->title }}" class="project-image">
                        <span class="project-badge {{ strtolower($similar->category) }}">{{ $similar->category }}</span>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">{{ $similar->title }}</h3>
                        <p class="project-description">{{ Str::limit($similar->description, 100) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
