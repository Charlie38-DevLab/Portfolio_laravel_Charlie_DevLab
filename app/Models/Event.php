<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'event_date',
        'duration',
        'price',
        'location',
        'max_participants',
        'registered_count',
        'image',
        'is_free',
        'is_featured',
        'features',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    // Relations
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_registrations')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        // return $query->where('event_date', '>', now())->orderBy('event_date', 'asc');
        // return $query->where('event_date', '>', now())->orderBy('event_date', 'asc');
        return $query->where('is_featured', true)->orderBy('event_date', 'asc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Vérifier s'il reste des places
    public function hasAvailableSlots()
    {
        if (!$this->max_participants) {
            return true;
        }
        return $this->registered_count < $this->max_participants;
    }

    // Obtenir le nombre de places restantes
    public function getAvailableSlotsAttribute()
    {
        if (!$this->max_participants) {
            return null;
        }
        return $this->max_participants - $this->registered_count;
    }
}
