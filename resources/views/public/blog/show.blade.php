@extends('layouts.app_layout')

@section('title', $post->title . ' - Blog')

@push('styles')
<style>
    .article-hero {
        padding: 8rem 2rem 4rem;
        background: linear-gradient(135deg, #0A0E27 0%, #151934 100%);
        position: relative;
        overflow: hidden;
    }

    .article-hero::before {
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

    .article-hero-content {
        max-width: 900px;
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

    .article-category {
        display: inline-block;
        padding: 0.5rem 1.2rem;
        background: var(--primary);
        color: white;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }

    .article-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.3;
    }

    .article-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--dark-border);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .meta-icon {
        width: 35px;
        height: 35px;
        background: var(--dark-card);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .author-info {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .author-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
    }

    .article-featured-image {
        margin: 4rem 0;
    }

    .featured-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 20px;
        border: 1px solid var(--dark-border);
    }

    .article-content-section {
        padding: 4rem 2rem;
        background: var(--dark-bg);
    }

    .article-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 4rem;
    }

    .article-main-content {
        max-width: 800px;
    }

    .article-content {
        font-size: 1.15rem;
        line-height: 1.9;
        color: var(--text-secondary);
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-content h2 {
        font-size: 2rem;
        font-weight: 700;
        margin: 3rem 0 1.5rem;
        color: var(--text-primary);
    }

    .article-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 2.5rem 0 1rem;
        color: var(--text-primary);
    }

    .article-content ul,
    .article-content ol {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }

    .article-content li {
        margin-bottom: 0.8rem;
    }

    .article-content code {
        background: var(--dark-card);
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.9em;
        color: var(--primary-light);
    }

    .article-content pre {
        background: var(--dark-card);
        padding: 1.5rem;
        border-radius: 12px;
        overflow-x: auto;
        margin: 2rem 0;
        border: 1px solid var(--dark-border);
    }

    .article-content pre code {
        background: none;
        padding: 0;
    }

    .article-tags {
        margin: 3rem 0;
        padding: 2rem 0;
        border-top: 1px solid var(--dark-border);
        border-bottom: 1px solid var(--dark-border);
    }

    .tags-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .tags-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .tag {
        padding: 0.6rem 1.2rem;
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        color: var(--text-secondary);
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .tag:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        color: var(--primary);
    }

    /* Sidebar */
    .article-sidebar {
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

    .author-card {
        text-align: center;
    }

    .author-card-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 2rem;
        margin: 0 auto 1rem;
    }

    .author-card-name {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .author-card-bio {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .share-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .share-btn {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.8rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        color: var(--text-primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .share-btn:hover {
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        transform: translateX(5px);
    }

    /* ================= RELATED ================= */
    .related-posts-section {
        padding: 5rem 2rem;
        background: var(--dark-card);
    }

    .related-posts-grid {
        max-width: 1200px;
        margin: auto;
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 2rem;
    }

    .related-card {
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 18px;
        overflow: hidden;
        transition: .4s;
        text-decoration: none;
    }

    .related-card:hover {
        transform: translateY(-8px);
        border-color: var(--primary);
    }

    .related-image {
        height: 180px;
        overflow: hidden;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-content {
        padding: 1.5rem;
    }

    .related-category {
        font-size: .75rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: .5rem;
    }

    .related-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: .6rem;
    }

    .related-excerpt {
        font-size: .9rem;
        color: var(--text-secondary);
    }

    .related-meta {
        margin-top: 1rem;
        font-size: .8rem;
        color: var(--text-secondary);
    }

    @media(max-width:1024px){
        .article-container{grid-template-columns:1fr}
        .related-posts-grid{grid-template-columns:repeat(2,1fr)}
    }
    @media(max-width:768px){
        .related-posts-grid{grid-template-columns:1fr}
        .article-title{font-size:2rem}
    }

    @media (max-width: 1024px) {
        .article-container {
            grid-template-columns: 1fr;
        }

        .article-sidebar {
            position: static;
        }

        .related-posts-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .article-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .related-posts-grid {
            grid-template-columns: 1fr;
        }

        .article-title {
            font-size: 2rem;
        }

        .article-content {
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<section class="article-hero">
    <div class="article-hero-content">
        <a href="{{ route('blog.index') }}" class="back-link">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Retour au blog
        </a>

        <span class="article-category">{{ $post->category }}</span>
        <h1 class="article-title">{{ $post->title }}</h1>

        <div class="article-meta">
            <div class="author-info">
                <div class="author-avatar">
                    {{ substr($post->author->name, 0, 1) }}
                </div>
                <span>{{ $post->author->name }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-icon">📅</span>
                {{ $post->published_at->format('d F Y') }}
            </div>
            <div class="meta-item">
                <span class="meta-icon">👁️</span>
                {{ $post->views_count }} vues
            </div>
        </div>
    </div>
</section>

<div class="article-featured-image">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
        <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=1200&h=600&fit=crop" alt="{{ $post->title }}" class="featured-image">
    </div>
</div>

<section class="article-content-section">
    <div class="article-container">
        <div class="article-main-content">
            <div class="article-content">
                {!! nl2br(e($post->content)) !!}
            </div>

            @if($post->tags)
                <div class="article-tags">
                    <h3 class="tags-title">Tags</h3>
                    <div class="tags-list">
                        @foreach($post->tags as $tag)
                            <span class="tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <aside class="article-sidebar">
            <div class="sidebar-card author-card">
                <div class="author-card-avatar">
                    {{ substr($post->author->name, 0, 1) }}
                </div>
                <h3 class="author-card-name">{{ $post->author->name }}</h3>
                <p class="author-card-bio">
                    Développeur Web Fullstack & Formateur Digital passionné par les nouvelles technologies.
                </p>
            </div>

            <div class="sidebar-card">
                <h3 class="sidebar-title">Partager</h3>
                <div class="share-buttons">
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" class="share-btn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        Twitter
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" class="share-btn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}" target="_blank" class="share-btn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        LinkedIn
                    </a>
                </div>
            </div>
        </aside>
    </div>
</section>

<!-- RELATED POSTS -->
@if($relatedPosts->count())
<section class="related-posts-section">
    <h2 style="text-align:center;margin-bottom:3rem">Articles similaires</h2>

    <div class="related-posts-grid">
        @foreach($relatedPosts as $related)
        <a href="{{ route('blog.show',$related->slug) }}" class="related-card">

            <div class="related-image">
                @if($related->featured_image)
                    <img src="{{ asset('storage/'.$related->featured_image) }}" alt="{{ $related->title }}">
                @endif
            </div>

            <div class="related-content">
                <div class="related-category">{{ $related->category }}</div>
                <h3 class="related-title">{{ Str::limit($related->title,55) }}</h3>
                <p class="related-excerpt">{{ Str::limit($related->excerpt,90) }}</p>
                <div class="related-meta">📅 {{ $related->published_at->format('d M Y') }}</div>
            </div>

        </a>
        @endforeach
    </div>
</section>
@endif

@endsection
