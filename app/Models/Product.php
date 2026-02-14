<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'price',
        'old_price',
        'discount_percentage',
        'image',
        'features',
        'sales_count',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });
    }

    // Scope pour les produits actifs
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope pour les produits populaires
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    // Scope par type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Calculer le prix avec réduction
    public function getFinalPriceAttribute()
    {
        if ($this->discount_percentage) {
            return $this->price - ($this->price * $this->discount_percentage / 100);
        }
        return $this->price;
    }
}
