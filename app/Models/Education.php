<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{

    protected $table = 'educations'; // 🔥 OBLIGATOIRE

    protected $fillable = [
        'degree',
        'school',
        'description',
        'icon',
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
