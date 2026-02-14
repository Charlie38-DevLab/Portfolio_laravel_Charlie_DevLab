@extends('layouts.app_layout')

@section('title', 'Blog - Charlie DevLab')

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

    .blog-content-section {
        padding: 4rem 2rem;
        background: var(--dark-bg);
    }

    .blog-container {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 4rem;
    }

    .blog-main {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .search-box {
        position: relative;
        margin-bottom: 2rem;
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        color: var(--text-primary);
        font-size: 1rem;
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
        margin-bottom: 2rem;
    }

    .filter-btn {
        padding: 0.6rem 1.2rem;
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.85rem;
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

    .blog-posts {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .blog-post-card {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        text-decoration: none;
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 0;
    }

    .blog-post-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary);
        box-shadow: 0 20px 40px rgba(108, 92, 231, 0.2);
    }

    .post-image-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        min-height: 250px;
        overflow: hidden;
        background: var(--dark-bg);
    }

    .post-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .blog-post-card:hover .post-image {
        transform: scale(1.1);
    }

    .post-category-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 0.4rem 0.8rem;
        background: var(--primary);
        color: white;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .post-content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
    }

    .post-meta {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .post-meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .post-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
        line-height: 1.4;
    }

    .post-excerpt {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    .post-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .tag {
        padding: 0.3rem 0.8rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 6px;
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .read-more {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.95rem;
    }

    /* Sidebar */
    .blog-sidebar {
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

    .popular-posts {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .popular-post-item {
        display: flex;
        gap: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .popular-post-item:hover {
        transform: translateX(5px);
    }

    .popular-post-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .popular-post-content {
        flex: 1;
    }

    .popular-post-title {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        line-height: 1.4;
    }

    .popular-post-date {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    @media (max-width: 1024px) {
        .blog-container {
            grid-template-columns: 1fr;
        }

        .blog-sidebar {
            position: static;
        }

        .blog-post-card {
            grid-template-columns: 1fr;
        }

        .post-image-wrapper {
            min-height: 200px;
        }

        .page-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')

<!-- ================= HEADER ================= -->
<section class="page-header">
    <div class="page-header-content">
        <div class="page-subtitle">BLOG</div>
        <h1 class="page-title">Articles & Tutoriels</h1>
        <p class="page-description">
            Découvrez mes articles sur le développement web, les nouvelles technologies et mes retours d'expérience.
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="blog-content-section">
    <div class="blog-container">

        <!-- ========== MAIN ========== -->
        <div class="blog-main">

            <!-- Search -->
            <div class="search-box">
                <form action="{{ route('blog.index') }}" method="GET">
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Rechercher un article..."
                        value="{{ request('search') }}"
                    >
                </form>
            </div>

            <!-- Categories -->
            <div class="category-filters">
                @foreach($categories as $cat)
                    <a
                        href="{{ route('blog.index', ['category' => $cat]) }}"
                        class="filter-btn {{ (!request('category') && $cat === 'all') || request('category') === $cat ? 'active' : '' }}"
                    >
                        {{ $cat === 'all' ? 'Tous' : ucfirst($cat) }}
                    </a>
                @endforeach
            </div>

            <!-- Posts -->
            @if($posts->count())
            <div class="blog-posts">

                @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="blog-post-card">

                    <!-- IMAGE -->
                    <div class="post-image-wrapper">
                        @if($post->featured_image)
                            <img
                                src="{{ asset('storage/' . $post->featured_image) }}"
                                alt="{{ $post->title }}"
                                class="post-image"
                                loading="lazy"
                            >
                        @else
                            <div style="
                                width:100%;
                                height:100%;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                background:linear-gradient(135deg,#6c5ce7,#00b8a9);
                                font-size:3rem;
                                color:white;">
                                📝
                            </div>
                        @endif

                        <span class="post-category-badge">
                            {{ $post->category }}
                        </span>
                    </div>

                    <!-- CONTENT -->
                    <div class="post-content">
                        <div class="post-meta">
                            <span>📅 {{ $post->published_at->format('d M Y') }}</span>
                            <span>👁 {{ $post->views_count }} vues</span>
                            <span>👤 {{ $post->author->name }}</span>
                        </div>

                        <h3 class="post-title">{{ $post->title }}</h3>

                        <p class="post-excerpt">
                            {{ $post->excerpt }}
                        </p>

                        @if(!empty($post->tags))
                        <div class="post-tags">
                            @foreach($post->tags as $tag)
                                <span class="tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif

                        <span class="read-more">
                            Lire l'article →
                        </span>
                    </div>

                </a>
                @endforeach

            </div>

            <div style="margin-top:3rem">
                {{ $posts->links() }}
            </div>

            @else
                <div style="text-align:center;padding:5rem">
                    <h3>Aucun article trouvé</h3>
                </div>
            @endif
        </div>

        <!-- ========== SIDEBAR ========== -->
        <aside class="blog-sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-title">Articles populaires</h3>

                <div class="popular-posts">
                    @foreach($popularPosts as $popular)
                    <a href="{{ route('blog.show', $popular->slug) }}" class="popular-post-item">

                        @if($popular->featured_image)
                            {{-- <img
                                src="{{ asset('storage/' . $popular->featured_image) }}"
                                class="popular-post-image"
                                alt="{{ $popular->title }}"
                                loading="lazy"
                            > --}}
                            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=100&h=100&fit=crop">
                        @else
                            <div style="
                                width:80px;
                                height:80px;
                                border-radius:10px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                background:#1e1e2e;">
                                📝
                            </div>
                        @endif

                        <div class="popular-post-content">
                            <h4 class="popular-post-title">
                                {{ Str::limit($popular->title, 55) }}
                            </h4>
                            <p class="popular-post-date">
                                {{ $popular->published_at->format('d M Y') }} • {{ $popular->views_count }} vues
                            </p>
                        </div>

                    </a>
                    @endforeach
                </div>
            </div>
        </aside>

    </div>
</section>

@endsection
