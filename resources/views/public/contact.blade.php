@extends('layouts.app_layout')

@section('title', 'Contact - Charlie DevLab')

@push('styles')
<style>
    .contact-hero {
        padding: 8rem 2rem 4rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
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

    .contact-hero-content {
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

    .contact-section {
        padding: 4rem 2rem;
        background: var(--dark-bg);
    }

    .contact-container {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
    }

    /* Contact Info */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .info-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
    }

    .info-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }

    .info-icon.email {
        background: linear-gradient(135deg, #667EEA, #764BA2);
    }

    .info-icon.phone {
        background: linear-gradient(135deg, #00D4AA, #00B8A9);
    }

    .info-icon.location {
        background: linear-gradient(135deg, #A29BFE, #6C5CE7);
    }

    .info-icon.social {
        background: linear-gradient(135deg, #FFA500, #FF8B4D);
    }

    .info-icon.whatsapp {
        background: linear-gradient(135deg, #25D366, #128C7E);
    }

    .info-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--text-primary);
    }

    .info-text {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 0.5rem;
    }

    .info-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .info-link:hover {
        color: var(--primary-light);
    }

    /* WhatsApp Button */
    .whatsapp-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        padding: 1rem 1.8rem;
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
    }

    .whatsapp-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
    }

    .whatsapp-btn svg {
        width: 24px;
        height: 24px;
    }

    .social-links {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .social-link {
        width: 45px;
        height: 45px;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }

    .social-link:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        color: var(--primary);
        transform: translateY(-3px);
    }

    /* Contact Form */
    .contact-form-wrapper {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 3rem;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .form-description {
        color: var(--text-secondary);
        margin-bottom: 2rem;
        line-height: 1.7;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.8rem;
    }

    .form-label .required {
        color: var(--error);
        margin-left: 0.2rem;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 1rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        color: var(--text-primary);
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.05);
    }

    .form-textarea {
        min-height: 150px;
        resize: vertical;
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: var(--text-secondary);
        opacity: 0.6;
    }

    .submit-btn {
        width: 100%;
        padding: 1.2rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.4);
    }

    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
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

    .error-message {
        color: var(--error);
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    /* Floating WhatsApp Button */
    .floating-whatsapp {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
    }

    .floating-whatsapp-btn {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #25D366, #128C7E);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        transition: all 0.3s ease;
        animation: pulse 2s infinite;
    }

    .floating-whatsapp-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 30px rgba(37, 211, 102, 0.6);
    }

    .floating-whatsapp-btn svg {
        width: 32px;
        height: 32px;
        fill: white;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        }
        50% {
            box-shadow: 0 4px 30px rgba(37, 211, 102, 0.7);
        }
        100% {
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        }
    }

    @media (max-width: 1024px) {
        .contact-container {
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

        .contact-form-wrapper {
            padding: 2rem;
        }

        .floating-whatsapp {
            bottom: 20px;
            right: 20px;
        }

        .floating-whatsapp-btn {
            width: 55px;
            height: 55px;
        }
    }
</style>
@endpush

@section('content')
<section class="contact-hero">
    <div class="contact-hero-content">
        <div class="page-subtitle">CONTACT</div>
        <h1 class="page-title">Restons en Contact</h1>
        <p class="page-description">
            Une question, un projet ou une collaboration ? N'hésitez pas à me contacter, je vous réponds dans les plus brefs délais.
        </p>
    </div>
</section>

<section class="contact-section">
    <div class="contact-container">
        <!-- Contact Info -->
        <div class="contact-info">
            <!-- WhatsApp Card -->
            <div class="info-card">
                <div class="info-icon whatsapp">
                    <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </div>
                <h3 class="info-title">WhatsApp</h3>
                <p class="info-text">Discutez directement avec moi sur WhatsApp pour une réponse rapide</p>
                <a href="https://wa.me/2290142089080" target="_blank" class="whatsapp-btn">
                    <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    Contactez-moi !
                </a>
            </div>

            <div class="info-card">
                <div class="info-icon email">📧</div>
                <h3 class="info-title">Email</h3>
                <p class="info-text">Pour toute demande professionnelle ou question</p>
                <a href="mailto:createchcharlie@gmail.com" class="info-link">contact@charliedevlab.com</a>
            </div>

            <div class="info-card">
                <div class="info-icon phone">📱</div>
                <h3 class="info-title">Téléphone</h3>
                <p class="info-text">Du lundi au vendredi de 9h à 18h</p>
                <a href="tel:+2290142089080" class="info-link">+229 01 42 08 90 80</a>
            </div>

            <div class="info-card">
                <div class="info-icon location">📍</div>
                <h3 class="info-title">Localisation</h3>
                <p class="info-text">Cotonou, Bénin</p>
                <p class="info-text">Disponible pour des projets en remote</p>
            </div>

            <div class="info-card">
                <div class="info-icon social">🌐</div>
                <h3 class="info-title">Réseaux Sociaux</h3>
                <p class="info-text">Suivez-moi sur les réseaux sociaux</p>
                <div class="social-links">
                    <a href="https://github.com/Charlie38-DevLab" target="_blank" class="social-link" title="GitHub">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/in/charlie-cr%C3%A9atech-46b8753a9/" target="_blank" class="social-link" title="LinkedIn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com/charliedevlab" target="_blank" class="social-link" title="Twitter">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="https://instagram.com/charliedevlab" target="_blank" class="social-link" title="Instagram">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form-wrapper">
            <h2 class="form-title">Envoyez-moi un message</h2>
            <p class="form-description">
                Remplissez le formulaire ci-dessous et je vous répondrai dans les 24 heures.
            </p>

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

            <form action="{{ route('public.contact') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">
                        Nom complet <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input"
                        placeholder="Votre nom complet"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        Email <span class="required">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="votre.email@exemple.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject" class="form-label">
                        Sujet <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        class="form-input"
                        placeholder="Sujet de votre message"
                        value="{{ old('subject') }}"
                        required
                    >
                    @error('subject')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="message" class="form-label">
                        Message <span class="required">*</span>
                    </label>
                    <textarea
                        id="message"
                        name="message"
                        class="form-textarea"
                        placeholder="Décrivez votre projet ou votre question..."
                        required
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    Envoyer le message
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Floating WhatsApp Button -->
<div class="floating-whatsapp">
    <a href="https://wa.me/2290142089080?text=Bonjour%20CharlieDevLab%2C%20je%20vous%20contacte%20depuis%20votre%20portfolio"
       target="_blank"
       class="floating-whatsapp-btn"
       title="Contactez-moi sur WhatsApp">
        <svg viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>
</div>
@endsection
