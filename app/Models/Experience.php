<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{

    protected $table = 'experiences'; // 🔥 OBLIGATOIRE

    protected $fillable = [
        'company',
        'position',
        'period',
        'description',
        'location',
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
