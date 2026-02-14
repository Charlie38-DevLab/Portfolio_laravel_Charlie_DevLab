@extends('layouts.app_layout')

@section('title', 'Modifier mon Profil - Odilon DevLab')

@push('styles')
<style>
    .profile-hero {
        padding: 8rem 2rem 4rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .profile-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 2rem;
        text-align: center;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .edit-form {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 3rem;
    }

    .form-section {
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--dark-border);
    }

    .avatar-upload-section {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .current-avatar {
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
        overflow: hidden;
    }

    .current-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-upload-info {
        flex: 1;
    }

    .avatar-upload-info h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .avatar-upload-info p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
    }

    .file-input {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }

    .file-input-label {
        padding: 0.8rem 1.5rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        cursor: pointer;
        display: inline-block;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .file-input-label:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
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

    .form-input {
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

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.05);
    }

    .form-input::placeholder {
        color: var(--text-secondary);
        opacity: 0.6;
    }

    .form-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .error-message {
        color: var(--error);
        font-size: 0.85rem;
        margin-top: 0.5rem;
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

    .password-hint {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--dark-border);
    }

    .btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cancel {
        background: var(--dark-bg);
        color: var(--text-primary);
        border: 1px solid var(--dark-border);
    }

    .btn-cancel:hover {
        border-color: var(--primary);
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.4);
    }

    @media (max-width: 768px) {
        .avatar-upload-section {
            flex-direction: column;
            text-align: center;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-hero"></div>

<div class="profile-container">
    <h1 class="page-title">Modifier mon Profil</h1>

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

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="edit-form">
        @csrf
        @method('PUT')

        <!-- Section Avatar -->
        <div class="form-section">
            <h2 class="section-title">Photo de Profil</h2>
            <div class="avatar-upload-section">
                <div class="current-avatar">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" id="avatar-preview">
                    @else
                        <span id="avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="avatar-upload-info">
                    <h3>Changer votre photo de profil</h3>
                    <p>JPG, PNG ou GIF. Taille maximale : 2MB</p>
                    <div class="file-input-wrapper">
                        <input
                            type="file"
                            id="avatar"
                            name="avatar"
                            class="file-input"
                            accept="image/jpeg,image/png,image/gif"
                            onchange="previewAvatar(event)"
                        >
                        <label for="avatar" class="file-input-label">
                            📁 Choisir une image
                        </label>
                    </div>
                    @error('avatar')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section Informations Personnelles -->
        <div class="form-section">
            <h2 class="section-title">Informations Personnelles</h2>

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
                    value="{{ old('name', $user->name) }}"
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
                    value="{{ old('email', $user->email) }}"
                    required
                >
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Section Mot de Passe -->
        <div class="form-section">
            <h2 class="section-title">Changer le Mot de Passe</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                Laissez ces champs vides si vous ne souhaitez pas modifier votre mot de passe.
            </p>

            <div class="form-group">
                <label for="current_password" class="form-label">
                    Mot de passe actuel
                </label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    class="form-input"
                    placeholder="Votre mot de passe actuel"
                >
                @error('current_password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password" class="form-label">
                    Nouveau mot de passe
                </label>
                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    class="form-input"
                    placeholder="Votre nouveau mot de passe"
                >
                <p class="password-hint">
                    Le mot de passe doit contenir au moins 8 caractères
                </p>
                @error('new_password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation" class="form-label">
                    Confirmer le nouveau mot de passe
                </label>
                <input
                    type="password"
                    id="new_password_confirmation"
                    name="new_password_confirmation"
                    class="form-input"
                    placeholder="Confirmez votre nouveau mot de passe"
                >
            </div>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <a href="{{ route('profile.index') }}" class="btn btn-cancel">Annuler</a>
            <button type="submit" class="btn btn-submit">Enregistrer les modifications</button>
        </div>
    </form>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarInitial = document.getElementById('avatar-initial');

            if (avatarPreview) {
                avatarPreview.src = e.target.result;
            } else if (avatarInitial) {
                const avatarContainer = avatarInitial.parentElement;
                avatarInitial.remove();
                const img = document.createElement('img');
                img.id = 'avatar-preview';
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                avatarContainer.appendChild(img);
            }
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
