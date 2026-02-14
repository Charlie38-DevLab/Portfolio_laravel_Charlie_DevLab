<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_id',
        'category',
        'tags',
        'views_count',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /* =======================
       RELATIONS
    ======================== */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /* =======================
       SCOPES
    ======================== */

    // Articles publiés uniquement
    public function scopePublished(Builder $query)
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    // Filtrer par catégorie
    public function scopeByCategory(Builder $query, string $category)
    {
        return $query->where('category', $category);
    }

    /* =======================
       MÉTHODES
    ======================== */

    // Incrémenter les vues
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
