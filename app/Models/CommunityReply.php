<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    /**
     * Le post auquel appartient la réponse
     */
    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }

    /**
     * L'auteur de la réponse
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
