@extends('layouts.admin')

@section('title', 'Gestion du Blog')

@section('content')
<div class="admin-header">
    <div>
        <h1>Gestion du Blog</h1>
        <p>Gérer les articles publiés et brouillons</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
        ➕ Nouvel Article
    </a>
</div>

<div class="card">
    @if($posts->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem; padding: 1rem;">
            @foreach($posts as $post)
                <div style="background: var(--dark-bg); border: 1px solid var(--dark-border); border-radius: 15px; overflow: hidden; transition: all .3s ease;"
                     onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-5px)'"
                     onmouseout="this.style.borderColor='var(--dark-border)'; this.style.transform='translateY(0)'">

                    <!-- Image -->
                    <div style="height: 200px; overflow: hidden; position: relative;">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/'.$post->featured_image) }}"
                                 alt="{{ $post->title }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div style="width:100%; height:100%; background:linear-gradient(135deg,var(--primary),var(--primary-light));
                                        display:flex; align-items:center; justify-content:center; font-size:3rem;">
                                📰
                            </div>
                        @endif

                        <div style="position:absolute; top:10px; left:10px;
                                    background: {{ $post->is_published ? '#2ecc71' : '#7f8c8d' }};
                                    color:white; padding:.4rem .8rem; border-radius:8px;
                                    font-size:.8rem; font-weight:600;">
                            {{ $post->is_published ? 'Publié' : 'Brouillon' }}
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div style="padding:1.5rem;">
                        <div style="display:inline-block; padding:.3rem .8rem;
                                    background:rgba(108,92,231,.1);
                                    color:var(--primary);
                                    border-radius:6px;
                                    font-size:.85rem;
                                    font-weight:600;
                                    margin-bottom:1rem;">
                            {{ $post->category }}
                        </div>

                        <h3 style="font-size:1.25rem; font-weight:700; margin-bottom:.8rem;">
                            {{ $post->title }}
                        </h3>

                        <p style="color:var(--text-secondary); line-height:1.6;
                                  display:-webkit-box; -webkit-line-clamp:2;
                                  -webkit-box-orient:vertical; overflow:hidden;">
                            {{ $post->excerpt }}
                        </p>

                        <div style="display:flex; justify-content:space-between;
                                    margin-top:1.2rem; padding-top:1rem;
                                    border-top:1px solid var(--dark-border);
                                    font-size:.9rem; color:var(--text-secondary);">
                            <span>📅 {{ $post->created_at->format('d/m/Y') }}</span>
                            <span>👁 {{ $post->views_count }}</span>
                        </div>

                        <!-- Actions -->
                        <div style="display:flex; gap:.5rem; margin-top:1.2rem;">
                            <a href="{{ route('admin.blog.edit', $post) }}"
                               class="btn btn-secondary" style="flex:1;">
                                ✏️ Éditer
                            </a>

                            <form action="{{ route('admin.blog.destroy', $post) }}"
                                  method="POST" style="flex:1;"
                                  onsubmit="return confirm('Supprimer cet article ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" style="width:100%;">
                                    🗑️ Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="padding:2rem; border-top:1px solid var(--dark-border);">
            {{ $posts->links() }}
        </div>
    @else
        <div style="text-align:center; padding:5rem 2rem;">
            <div style="font-size:5rem; opacity:.5;">📰</div>
            <h3>Aucun article</h3>
            <p>Commence par créer ton premier article</p>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                ➕ Créer un article
            </a>
        </div>
    @endif
</div>
@endsection
