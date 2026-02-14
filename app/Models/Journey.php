<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $table = 'journeys'; // 🔥 OBLIGATOIRE

    protected $fillable = [
        'year',
        'title',
        'description',
        'ordre',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre', 'asc');
    }
}
