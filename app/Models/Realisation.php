<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Realisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'image',
        'technologies',
        'client',
        'completion_date',
        'project_url',
        'featured',
    ];

    protected $casts = [
        'technologies' => 'array',
        'completion_date' => 'date',
        'featured' => 'boolean',
    ];

    // Générer automatiquement le slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($realisation) {
            if (empty($realisation->slug)) {
                $realisation->slug = Str::slug($realisation->title);
            }
        });
    }

    // Scope pour les projets featured
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Scope par catégorie
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
