@extends('layouts.app_layout')

@section('title', 'À Propos - Charlie DevLab')

@push('styles')
<style>
    .about-hero {
        min-height: 80vh;
        display: flex;
        align-items: center;
        padding: 8rem 2rem 4rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
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

    .about-hero-content {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .about-text {
        animation: fadeInUp 0.8s ease-out;
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
        line-height: 1.3;
    }

    .about-description {
        font-size: 1.2rem;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }

    .about-image-wrapper {
        position: relative;
        animation: fadeIn 1s ease-out 0.4s backwards;
    }

    .about-image {
        width: 100%;
        border-radius: 20px;
        border: 3px solid var(--primary);
        box-shadow: 0 20px 60px rgba(108, 92, 231, 0.3);
    }

    /* Journey Section */
    .journey-section {
        padding: 6rem 2rem;
        background: var(--dark-bg);
    }

    .journey-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-align: center;
        color: var(--text-primary);
    }

    .section-description {
        font-size: 1.1rem;
        color: var(--text-secondary);
        text-align: center;
        max-width: 700px;
        margin: 0 auto 4rem;
        line-height: 1.8;
    }

    .timeline {
        position: relative;
        padding-left: 3rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--primary), var(--secondary));
    }

    .timeline-item {
        position: relative;
        margin-bottom: 3rem;
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .timeline-item:nth-child(1) { animation-delay: 0.1s; }
    .timeline-item:nth-child(2) { animation-delay: 0.2s; }
    .timeline-item:nth-child(3) { animation-delay: 0.3s; }
    .timeline-item:nth-child(4) { animation-delay: 0.4s; }
    .timeline-item:nth-child(5) { animation-delay: 0.5s; }

    .timeline-dot {
        position: absolute;
        left: -3.5rem;
        top: 0.5rem;
        width: 20px;
        height: 20px;
        background: var(--primary);
        border-radius: 50%;
        box-shadow: 0 0 0 4px var(--dark-bg), 0 0 0 6px var(--primary);
    }

    .timeline-content {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 15px;
        padding: 2rem;
        transition: all 0.3s ease;
    }

    .timeline-content:hover {
        border-color: var(--primary);
        transform: translateX(10px);
    }

    .timeline-year {
        font-size: 0.9rem;
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .timeline-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--text-primary);
    }

    .timeline-description {
        color: var(--text-secondary);
        line-height: 1.7;
    }

    /* Values Section */
    .values-section {
        padding: 6rem 2rem;
        background: var(--dark-card);
    }

    .values-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 4rem;
    }

    .value-card {
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        transition: all 0.4s ease;
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .value-card:nth-child(1) { animation-delay: 0.1s; }
    .value-card:nth-child(2) { animation-delay: 0.2s; }
    .value-card:nth-child(3) { animation-delay: 0.3s; }

    .value-card:hover {
        transform: translateY(-10px);
        border-color: var(--primary);
        box-shadow: 0 20px 40px rgba(108, 92, 231, 0.2);
    }

    .value-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
    }

    .value-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .value-description {
        color: var(--text-secondary);
        line-height: 1.7;
    }

    /* Education Section */
    .education-section {
        padding: 6rem 2rem;
        background: var(--dark-bg);
    }

    .education-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .education-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-top: 4rem;
    }

    .education-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2.5rem;
        transition: all 0.4s ease;
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .education-card:nth-child(1) { animation-delay: 0.1s; }
    .education-card:nth-child(2) { animation-delay: 0.2s; }

    .education-card:hover {
        border-color: var(--secondary);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 184, 169, 0.2);
    }

    .education-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--secondary), #00E5D0);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    .education-degree {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .education-school {
        font-size: 1.1rem;
        color: var(--secondary);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .education-description {
        color: var(--text-secondary);
        line-height: 1.7;
    }

    /* CTA Section */
    .cta-section {
        padding: 6rem 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        animation: gradient-shift 15s ease infinite;
        background-size: 200% 200%;
    }

    .cta-container {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .cta-title {
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1.5rem;
        line-height: 1.3;
    }

    .cta-description {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 3rem;
        line-height: 1.8;
    }

    .cta-buttons {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-white {
        padding: 1rem 2rem;
        background: white;
        color: var(--primary);
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
    }

    .btn-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 1024px) {
        .about-hero-content {
            grid-template-columns: 1fr;
        }

        .values-grid {
            grid-template-columns: 1fr;
        }

        .education-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .cta-title {
            font-size: 2rem;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .btn-white {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="about-hero-content">
        <div class="about-text">
            <div class="page-subtitle">À PROPOS</div>
            <h1 class="page-title">Passionné par le Code et l'Enseignement</h1>
            <p class="about-description">
                Je suis Charlie, développeur web fullstack et formateur digital. Mon objectif est de créer des solutions digitales innovantes tout en transmettant mes connaissances à la prochaine génération de développeurs.
            </p>
            <p class="about-description">
                Actuellement en Licence 3 Système Informatique & Logiciel et Licence 2 Sciences de l'Éducation, je combine expertise technique et pédagogie pour offrir des expériences d'apprentissage exceptionnelles.
            </p>
        </div>
        <div class="about-image-wrapper">
            <img src="/images/Profile.jpg" alt="Charlie DevLab" class="about-image">
        </div>
    </div>
</section>

{{-- <!-- Journey Section -->
<section class="journey-section">
    <div class="journey-container">
        <h2 class="section-title">Mon Parcours</h2>
        <p class="section-description">
            Découvrez les étapes clés qui ont façonné mon parcours de développeur et de formateur.
        </p>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2025 - Présent</div>
                    <h3 class="timeline-title">Développeur Fullstack & Formateur</h3>
                    <p class="timeline-description">
                        Création de solutions web innovantes et accompagnement de développeurs débutants dans leur apprentissage. Formation sur Laravel, React, et les meilleures pratiques du développement web moderne.
                    </p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2024</div>
                    <h3 class="timeline-title">Licence 3 Système Informatique & Logiciel</h3>
                    <p class="timeline-description">
                        Approfondissement des connaissances en architecture logicielle, bases de données avancées, et développement d'applications complexes.
                    </p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2023</div>
                    <h3 class="timeline-title">Licence 2 Sciences de l'Éducation</h3>
                    <p class="timeline-description">
                        Acquisition de compétences pédagogiques pour transmettre efficacement les connaissances techniques et accompagner les apprenants dans leur progression.
                    </p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2022</div>
                    <h3 class="timeline-title">Premiers Projets Freelance</h3>
                    <p class="timeline-description">
                        Début de l'activité freelance avec la réalisation de sites web et d'applications pour des clients locaux. Développement de compétences en gestion de projet et relation client.
                    </p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2020</div>
                    <h3 class="timeline-title">Début de l'Aventure</h3>
                    <p class="timeline-description">
                        Découverte du développement web et coup de foudre pour la programmation. Apprentissage autodidacte de HTML, CSS, JavaScript et PHP.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section> --}}


<!-- Remplacer la section Journey par : -->
<section class="journey-section">
    <div class="journey-container">
        <h2 class="section-title">Mon Parcours</h2>
        <p class="section-description">
            Découvrez les étapes clés qui ont façonné mon parcours de développeur et de formateur.
        </p>

        <div class="timeline">
            @forelse($journeys as $index => $journey)
            <div class="timeline-item" style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">{{ $journey->year }}</div>
                    <h3 class="timeline-title">{{ $journey->title }}</h3>
                    <p class="timeline-description">{{ $journey->description }}</p>
                </div>
            </div>
            @empty
            <p class="text-center" style="color: var(--text-secondary);">Aucun parcours disponible pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Remplacer la section Education par : -->
<section class="education-section">
    <div class="education-container">
        <h2 class="section-title">Formation</h2>
        <p class="section-description">
            Mon parcours académique qui allie technique et pédagogie.
        </p>

        <div class="education-grid">
            @forelse($educations as $index => $education)
            <div class="education-card" style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="education-icon">{{ $education->icon }}</div>
                <h3 class="education-degree">{{ $education->degree }}</h3>
                <p class="education-school">{{ $education->school }}</p>
                <p class="education-description">{{ $education->description }}</p>
            </div>
            @empty
            <p class="text-center" style="color: var(--text-secondary); grid-column: 1 / -1;">Aucune formation disponible pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Ajouter cette nouvelle section après Education : -->
@if($experiences->isNotEmpty())
<section class="journey-section">
    <div class="journey-container">
        <h2 class="section-title">Expériences Professionnelles</h2>
        <p class="section-description">
            Mon parcours professionnel et les missions que j'ai eu l'opportunité de réaliser.
        </p>

        <div class="timeline">
            @foreach($experiences as $index => $experience)
            <div class="timeline-item" style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-year">{{ $experience->period }}</div>
                    <h3 class="timeline-title">{{ $experience->position }}</h3>
                    <p class="education-school" style="margin-bottom: 1rem;">
                        {{ $experience->company }}
                        @if($experience->location)
                        <span style="color: var(--text-secondary);"> • {{ $experience->location }}</span>
                        @endif
                    </p>
                    <p class="timeline-description">{{ $experience->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


<!-- Values Section -->
<section class="values-section">
    <div class="values-container">
        <h2 class="section-title">Mes Valeurs</h2>
        <p class="section-description">
            Les principes qui guident mon travail au quotidien.
        </p>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">💡</div>
                <h3 class="value-title">Innovation</h3>
                <p class="value-description">
                    Toujours à la recherche des dernières technologies et des meilleures pratiques pour créer des solutions modernes et performantes.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🎯</div>
                <h3 class="value-title">Excellence</h3>
                <p class="value-description">
                    Engagement à fournir un travail de qualité supérieure, avec une attention particulière aux détails et à l'expérience utilisateur.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3 class="value-title">Transmission</h3>
                <p class="value-description">
                    Passion pour l'enseignement et le partage de connaissances. Former la prochaine génération de développeurs est une mission qui me tient à cœur.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- <!-- Education Section -->
<section class="education-section">
    <div class="education-container">
        <h2 class="section-title">Formation</h2>
        <p class="section-description">
            Mon parcours académique qui allie technique et pédagogie.
        </p>

        <div class="education-grid">
            <div class="education-card">
                <div class="education-icon">🎓</div>
                <h3 class="education-degree">Licence 3 Système Informatique & Logiciel</h3>
                <p class="education-school">Université</p>
                <p class="education-description">
                    Formation approfondie en développement logiciel, architecture système, bases de données, et gestion de projets informatiques. Spécialisation en développement web et mobile.
                    Développement logiciel, bases de données, systèmes et web.
                </p>
            </div>

            <div class="education-card">
                <div class="education-icon">📚</div>
                <h3 class="education-degree">Licence 2 Sciences de l'Éducation</h3>
                <p class="education-school">Université</p>
                <p class="education-description">
                    Étude des méthodes pédagogiques, psychologie de l'apprentissage, et techniques d'enseignement. Cette formation me permet d'être un formateur plus efficace et à l'écoute de mes apprenants.
                    Méthodes pédagogiques et psychologie de l’apprentissage.
                </p>
            </div>
        </div>
    </div>
</section> --}}

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-container">
        <h2 class="cta-title">Travaillons Ensemble</h2>
        <p class="cta-description">
            Vous avez un projet en tête ou souhaitez vous former au développement web ? N'hésitez pas à me contacter !
        </p>
        <div class="cta-buttons">
            <a href="{{ route('public.contact') }}" class="btn-white">
                Me Contacter
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="{{ route('product.index') }}" class="btn-white">
                Voir mes Formations
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
