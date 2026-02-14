@extends('layouts.admin')

@section('title', 'Gestion des Réalisations')

@section('content')
<div class="admin-header">
    <div>
        <h1>Gestion des Réalisations</h1>
        <p>Gérer tous les projets et réalisations du portfolio</p>
    </div>
    <a href="{{ route('admin.realisations.create') }}" class="btn btn-primary">
        ➕ Nouvelle Réalisation
    </a>
</div>

<!-- Liste des réalisations -->
<div class="card">
    @if($realisations->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem; padding: 1rem;">
            @foreach($realisations as $realisation)
                <div style="background: var(--dark-bg); border: 1px solid var(--dark-border); border-radius: 15px; overflow: hidden; transition: all 0.3s ease;"
                     onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'"
                     onmouseout="this.style.borderColor='var(--dark-border)'; this.style.transform='translateY(0)'">

                    <!-- Image -->
                    <div style="position: relative; height: 200px; overflow: hidden;">
                        @if($realisation->image)
                            {{-- <img src="{{ asset('storage/' . $realisation->image) }}"
                                 alt="{{ $realisation->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover;"> --}}

                            <img
                                src="{{ route('realisations.image', basename($realisation->image)) }}"
                                alt="{{ $realisation->title }}"
                                style="width: 100%; height: 100%; object-fit: cover;"
                            >
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                                🎨
                            </div>
                        @endif

                        @if($realisation->featured)
                            <div style="position: absolute; top: 10px; right: 10px; background: linear-gradient(135deg, #FFB800, #FFA000); color: white; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem;">
                                ⭐ À la une
                            </div>
                        @endif
                    </div>

                    <!-- Contenu -->
                    <div style="padding: 1.5rem;">
                        <!-- Catégorie -->
                        <div style="display: inline-block; padding: 0.3rem 0.8rem; background: rgba(108, 92, 231, 0.1); color: var(--primary); border-radius: 6px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1rem;">
                            {{ $realisation->category }}
                        </div>

                        <!-- Titre -->
                        <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 0.8rem; color: var(--text-primary);">
                            {{ $realisation->title }}
                        </h3>

                        <!-- Description -->
                        <p style="color: var(--text-secondary); line-height: 1.6; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $realisation->description }}
                        </p>

                        <!-- Technologies -->
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;">
                            @foreach(array_slice($realisation->technologies ?? [], 0, 3) as $tech)
                                <span style="padding: 0.3rem 0.8rem; background: var(--dark-card); border: 1px solid var(--dark-border); border-radius: 6px; font-size: 0.8rem; color: var(--text-secondary);">
                                    {{ $tech }}
                                </span>
                            @endforeach
                            @if(count($realisation->technologies ?? []) > 3)
                                <span style="padding: 0.3rem 0.8rem; background: var(--dark-card); border: 1px solid var(--dark-border); border-radius: 6px; font-size: 0.8rem; color: var(--text-secondary);">
                                    +{{ count($realisation->technologies) - 3 }}
                                </span>
                            @endif
                        </div>

                        <!-- Infos -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--dark-border);">
                            <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">
                                📅 {{ $realisation->completion_date->format('d/m/Y') }}
                            </div>
                            @if($realisation->client)
                                <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-secondary); font-size: 0.9rem;">
                                    👤 {{ $realisation->client }}
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; gap: 0.5rem;">
                            @if($realisation->project_url)
                                <a href="{{ $realisation->project_url }}"
                                   target="_blank"
                                   class="btn btn-secondary"
                                   style="flex: 1; text-align: center; padding: 0.8rem;">
                                    🔗 Voir
                                </a>
                            @endif
                            <a href="{{ route('admin.realisations.edit', $realisation->id) }}"
                               class="btn btn-secondary"
                               style="flex: 1; text-align: center; padding: 0.8rem;">
                                ✏️ Éditer
                            </a>
                            <form action="{{ route('admin.realisations.destroy', $realisation->id) }}"
                                  method="POST"
                                  style="flex: 1;"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réalisation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width: 100%; padding: 0.8rem;">
                                    🗑️ Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="padding: 2rem; border-top: 1px solid var(--dark-border);">
            {{ $realisations->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 5rem 2rem; color: var(--text-secondary);">
            <div style="font-size: 5rem; margin-bottom: 1.5rem; opacity: 0.5;">🎨</div>
            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Aucune réalisation</h3>
            <p style="margin-bottom: 2rem;">Commencez par créer votre première réalisation</p>
            <a href="{{ route('admin.realisations.create') }}" class="btn btn-primary">
                ➕ Créer une réalisation
            </a>
        </div>
    @endif
</div>

<style>
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
}

@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}
</style>
@endsection
