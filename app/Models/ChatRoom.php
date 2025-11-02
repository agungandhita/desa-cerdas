<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'name',
        'description',
        'topic',
        'status',
        'is_private',
        'max_participants',
        'allowed_users',
        'last_activity'
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'allowed_users' => 'array',
        'last_activity' => 'datetime'
    ];

    /**
     * Relationship dengan User (pembuat room)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship dengan ChatMessage
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Get latest message
     */
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }

    /**
     * Get active messages
     */
    public function activeMessages(): HasMany
    {
        return $this->messages()->where('message_type', '!=', 'system');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    public function scopeByTopic($query, $topic)
    {
        return $query->where('topic', $topic);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('last_activity', 'desc');
    }

    /**
     * Methods
     */
    public function updateLastActivity()
    {
        $this->update(['last_activity' => now()]);
    }

    public function getParticipantCount()
    {
        return $this->messages()->distinct('user_id')->count('user_id');
    }

    public function canUserJoin($userId)
    {
        if (!$this->is_private) {
            return true;
        }

        if ($this->created_by == $userId) {
            return true;
        }

        if ($this->allowed_users && in_array($userId, $this->allowed_users)) {
            return true;
        }

        return false;
    }

    public function hasReachedMaxParticipants()
    {
        if (!$this->max_participants) {
            return false;
        }

        return $this->getParticipantCount() >= $this->max_participants;
    }

    /**
     * Accessors
     */
    public function getMessageCountAttribute()
    {
        return $this->messages()->count();
    }

    public function getLastActivityHumanAttribute()
    {
        return $this->last_activity ? $this->last_activity->diffForHumans() : 'Belum ada aktivitas';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => 'bg-green-100 text-green-800',
            'closed' => 'bg-red-100 text-red-800',
            'archived' => 'bg-gray-100 text-gray-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}
