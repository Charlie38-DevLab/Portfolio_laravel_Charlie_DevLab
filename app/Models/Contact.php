<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Statuts possibles
    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';

    /**
     * Vérifier si le message est nouveau
     */
    public function isNew()
    {
        return $this->status === self::STATUS_NEW;
    }

    /**
     * Vérifier si le message a été lu
     */
    public function isRead()
    {
        return $this->status === self::STATUS_READ;
    }

    /**
     * Vérifier si le message a reçu une réponse
     */
    public function isReplied()
    {
        return $this->status === self::STATUS_REPLIED;
    }

    /**
     * Marquer comme lu
     */
    public function markAsRead()
    {
        $this->update(['status' => self::STATUS_READ]);
    }

    /**
     * Marquer comme répondu
     */
    public function markAsReplied()
    {
        $this->update(['status' => self::STATUS_REPLIED]);
    }

    /**
     * Scope pour obtenir les nouveaux messages
     */
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    /**
     * Scope pour obtenir les messages lus
     */
    public function scopeRead($query)
    {
        return $query->where('status', self::STATUS_READ);
    }

    /**
     * Scope pour obtenir les messages avec réponse
     */
    public function scopeReplied($query)
    {
        return $query->where('status', self::STATUS_REPLIED);
    }
}
