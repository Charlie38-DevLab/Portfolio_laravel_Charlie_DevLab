<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'title',
        'content',
        'is_pinned',
        'is_locked',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    /**
     * Le groupe auquel appartient le post
     */
    public function group()
    {
        return $this->belongsTo(CommunityGroup::class, 'group_id');
    }

    /**
     * L'auteur du post
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Les réponses au post
     */
    public function replies()
    {
        return $this->hasMany(CommunityReply::class, 'post_id');
    }
}
