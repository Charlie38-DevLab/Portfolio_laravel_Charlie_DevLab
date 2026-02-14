@extends('layouts.app_layout')

@section('title', 'Réalisations - Charlie DevLab')

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

    /* Filters Section */
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
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        min-width: 250px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 0.8rem 1rem 0.8rem 3rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        color: var(--text-primary);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.05);
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
    }

    .category-filters {
        display: flex;
        gap: 0.8rem;
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
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        color: var(--primary);
    }

    .filter-btn.active {
        background: var(--primary);
        color: white;
    }

    /* Projects Grid */
    .projects-section {
        padding: 4rem 2rem;
        background: var(--dark-bg);
    }

    .projects-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .project-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .project-card:hover {
        transform: translateY(-10px);
        border-color: var(--primary);
        box-shadow: 0 20px 40px rgba(108, 92, 231, 0.2);
    }

    .project-image-wrapper {
        position: relative;
        width: 100%;
        height: 280px;
        overflow: hidden;
        background: var(--dark-bg);
    }

    .project-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .project-card:hover .project-image {
        transform: scale(1.1);
    }

    .project-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(10, 14, 39, 0.9) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
    }

    .project-card:hover .project-overlay {
        opacity: 1;
    }

    .view-project-btn {
        padding: 0.7rem 1.5rem;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .project-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 0.5rem 1rem;
        background: rgba(10, 14, 39, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .project-badge.web {
        color: #667EEA;
        border: 1px solid #667EEA;
    }

    .project-badge.mobile {
        color: #00D4AA;
        border: 1px solid #00D4AA;
    }

    .project-badge.design {
        color: #FF6B9D;
        border: 1px solid #FF6B9D;
    }

    .featured-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, var(--warning), #FFA500);
        color: white;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .project-content {
        padding: 2rem;
    }

    .project-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--text-primary);
    }

    .project-description {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .project-technologies {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .tech-tag {
        padding: 0.4rem 0.9rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 6px;
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
        font-family: 'JetBrains Mono', monospace;
    }

    .project-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.5rem;
        border-top: 1px solid var(--dark-border);
    }

    .project-client {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .project-date {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 6rem 2rem;
    }

    .empty-state-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 2rem;
        background: var(--dark-card);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--text-primary);
    }

    .empty-state-description {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .projects-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .page-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .projects-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 2rem;
        }

        .filters-container {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }

        .category-filters {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="page-header-content">
        <div class="page-subtitle">PORTFOLIO</div>
        <h1 class="page-title">Mes Réalisations</h1>
        <p class="page-description">
            Découvrez mes projets les plus récents, allant des sites web aux applications mobiles.
        </p>
    </div>
</section>

<!-- Filters Section -->
<section class="filters-section">
    <div class="filters-container">
        <!-- Search Box -->
        <div class="search-box">
            <svg class="search-icon" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>
            <input
                type="text"
                class="search-input"
                placeholder="Rechercher un projet..."
                id="searchInput"
            >
        </div>

        <!-- Category Filters -->
        <div class="category-filters">
            @foreach($categories as $cat)
                <a
                    href="{{ route('realisations.index', ['category' => $cat]) }}"
                    class="filter-btn {{ (!request('category') && $cat == 'all') || request('category') == $cat ? 'active' : '' }}"
                >
                    {{ ucfirst($cat == 'all' ? 'Tous' : $cat) }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="projects-section">
    <div class="projects-container">
        @if($realisations->count() > 0)
            <div class="projects-grid">
                @foreach($realisations as $realisation)
                    <a href="{{ route('realisations.show', $realisation->slug) }}" class="project-card">
                        <div class="project-image-wrapper">
                            {{-- <img src="{{ asset('storage/' . $realisation->image) }}" alt="{{ $realisation->title }}" class="project-image"> --}}
                            <img
                                src="{{ route('realisations.image', basename($realisation->image)) }}"
                                alt="{{ $realisation->title }}"
                                class="project-image"
                            >

                            <span class="project-badge {{ strtolower($realisation->category) }}">
                                {{ $realisation->category }}
                            </span>

                            @if($realisation->featured)
                                <span class="featured-badge">⭐ Featured</span>
                            @endif

                            <div class="project-overlay">
                                <span class="view-project-btn">
                                    Voir le projet
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="project-content">
                            <h3 class="project-title">{{ $realisation->title }}</h3>
                            <p class="project-description">{{ Str::limit($realisation->description, 120) }}</p>

                            <div class="project-technologies">
                                @foreach($realisation->technologies as $tech)
                                    <span class="tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>

                            <div class="project-meta">
                                <span class="project-client">{{ $realisation->client ?? 'Personnel' }}</span>
                                <span class="project-date">{{ $realisation->completion_date->format('M Y') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper" style="margin-top: 3rem;">
                {{ $realisations->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <h3 class="empty-state-title">Aucun projet trouvé</h3>
                <p class="empty-state-description">
                    Essayez de modifier vos critères de recherche ou parcourez toutes les catégories.
                </p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const projectCards = document.querySelectorAll('.project-card');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        projectCards.forEach(card => {
            const title = card.querySelector('.project-title').textContent.toLowerCase();
            const description = card.querySelector('.project-description').textContent.toLowerCase();
            const techTags = Array.from(card.querySelectorAll('.tech-tag')).map(tag => tag.textContent.toLowerCase());

            const matches = title.includes(searchTerm) ||
                          description.includes(searchTerm) ||
                          techTags.some(tag => tag.includes(searchTerm));

            card.style.display = matches ? 'block' : 'none';
        });
    });
</script>
@endpush
@endsection
