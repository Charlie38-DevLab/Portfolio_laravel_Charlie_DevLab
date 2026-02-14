@extends('layouts.app_layout')

@section('title', 'Inscription - Charlie DevLab')

@push('styles')
<style>
    /* Réutilise les styles de login.blade.php */
    .auth-page {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .auth-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 20% 50%, rgba(108, 92, 231, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(0, 184, 169, 0.1) 0%, transparent 50%);
        animation: gradient-shift 15s ease infinite;
        background-size: 200% 200%;
    }

    .auth-container {
        max-width: 480px;
        width: 100%;
        position: relative;
        z-index: 1;
        animation: fadeInUp 0.6s ease-out;
    }

    .auth-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 24px;
        padding: 3rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .auth-logo {
        width: 60px;
        height: 60px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
    }

    .auth-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .auth-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.2rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        color: var(--text-primary);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.05);
    }

    .form-input::placeholder {
        color: var(--text-secondary);
        opacity: 0.6;
    }

    .form-error {
        color: var(--error);
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
    }

    .password-requirements {
        margin-top: 0.8rem;
        padding: 1rem;
        background: rgba(108, 92, 231, 0.05);
        border: 1px solid rgba(108, 92, 231, 0.2);
        border-radius: 10px;
    }

    .password-requirements p {
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .password-requirements ul {
        list-style: none;
        padding-left: 0;
    }

    .password-requirements li {
        color: var(--text-secondary);
        font-size: 0.8rem;
        padding: 0.3rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .password-requirements li::before {
        content: '✓';
        color: var(--success);
        font-weight: 700;
    }

    .terms-group {
        margin-bottom: 1.5rem;
    }

    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 0.7rem;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-top: 0.2rem;
        cursor: pointer;
    }

    .checkbox-group label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        line-height: 1.6;
        cursor: pointer;
    }

    .checkbox-group label a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .checkbox-group label a:hover {
        color: var(--primary-light);
    }

    .btn-submit {
        width: 100%;
        padding: 1.1rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .btn-submit:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .divider {
        text-align: center;
        margin: 2rem 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--dark-border);
    }

    .divider span {
        background: var(--dark-card);
        padding: 0 1rem;
        color: var(--text-secondary);
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
    }

    .social-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-social {
        flex: 1;
        padding: 1rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
        text-decoration: none;
    }

    .btn-social:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.05);
        transform: translateY(-2px);
    }

    .btn-social svg {
        width: 20px;
        height: 20px;
    }

    .auth-footer {
        text-align: center;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .auth-footer a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .auth-footer a:hover {
        color: var(--primary-light);
    }

    @media (max-width: 768px) {
        .auth-card {
            padding: 2rem;
        }

        .auth-title {
            font-size: 1.5rem;
        }

        .social-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">&lt;/&gt;</div>
                <h1 class="auth-title">Inscription</h1>
                <p class="auth-subtitle">Créez votre compte et rejoignez la communauté</p>
            </div>

            <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nom complet</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input"
                        placeholder="Votre nom complet"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    >
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="votre@email.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror

                    <div class="password-requirements">
                        <p>Le mot de passe doit contenir :</p>
                        <ul>
                            <li>Au moins 8 caractères</li>
                            <li>Une lettre majuscule et une minuscule</li>
                            <li>Un chiffre</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <div class="terms-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            J'accepte les <a href="#">Conditions d'utilisation</a> et
                            la <a href="#">Politique de confidentialité</a>
                        </label>
                    </div>
                    @error('terms')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Créer mon compte
                </button>
            </form>

            <div class="divider">
                <span>OU S'INSCRIRE AVEC</span>
            </div>

            <div class="social-buttons">
                <a href="{{ route('social.redirect', 'google') }}" class="btn-social">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </a>
                <a href="{{ route('social.redirect', 'github') }}" class="btn-social">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                    </svg>
                    GitHub
                </a>
            </div>

            <div class="auth-footer">
                Vous avez déjà un compte ?
                <a href="{{ route('login') }}">Connectez-vous</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validation du formulaire côté client
    const form = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    form.addEventListener('submit', function(e) {
        if (password.value !== passwordConfirmation.value) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas');
            passwordConfirmation.focus();
        }
    });

    // Vérification de la force du mot de passe
    password.addEventListener('input', function() {
        const value = this.value;
        const hasMinLength = value.length >= 8;
        const hasUpperCase = /[A-Z]/.test(value);
        const hasLowerCase = /[a-z]/.test(value);
        const hasNumber = /[0-9]/.test(value);

        // Vous pouvez ajouter des indicateurs visuels ici
    });
</script>
@endpush
@endsection
