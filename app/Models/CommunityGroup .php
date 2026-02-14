<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Les posts du groupe
     */
    public function posts()
    {
        return $this->hasMany(CommunityPost::class, 'group_id');
    }

    /**
     * Les membres du groupe
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'community_group_members', 'group_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Route key name
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
