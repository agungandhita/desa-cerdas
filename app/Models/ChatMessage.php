<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_room_id',
        'user_id',
        'message',
        'message_type',
        'file_path',
        'file_name',
        'file_size',
        'is_edited',
        'edited_at',
        'read_by',
        'reply_to'
    ];

    protected $casts = [
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
        'read_by' => 'array'
    ];

    protected $appends = [
        'file_url',
        'time_ago'
    ];

    /**
     * Relationships
     */
    public function chatRoom(): BelongsTo
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'reply_to');
    }

    public function replies()
    {
        return $this->hasMany(ChatMessage::class, 'reply_to');
    }

    /**
     * Scopes
     */
    public function scopeText($query)
    {
        return $query->where('message_type', 'text');
    }

    public function scopeFiles($query)
    {
        return $query->whereIn('message_type', ['image', 'file']);
    }

    public function scopeSystem($query)
    {
        return $query->where('message_type', 'system');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * Methods
     */
    public function markAsRead($userId)
    {
        $readBy = $this->read_by ?? [];

        if (!in_array($userId, $readBy)) {
            $readBy[] = $userId;
            $this->update(['read_by' => $readBy]);
        }
    }

    public function isReadBy($userId)
    {
        return $this->read_by && in_array($userId, $this->read_by);
    }

    public function markAsEdited()
    {
        $this->update([
            'is_edited' => true,
            'edited_at' => now()
        ]);
    }

    public function isReply()
    {
        return !is_null($this->reply_to);
    }

    public function hasFile()
    {
        return in_array($this->message_type, ['image', 'file']) && $this->file_path;
    }

    /**
     * Accessors
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('H:i');
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    public function getMessageTypeIconAttribute()
    {
        $icons = [
            'text' => 'fas fa-comment',
            'image' => 'fas fa-image',
            'file' => 'fas fa-file',
            'system' => 'fas fa-info-circle'
        ];

        return $icons[$this->message_type] ?? 'fas fa-comment';
    }

    public function getMessageTypeBadgeAttribute()
    {
        $badges = [
            'text' => 'bg-blue-100 text-blue-800',
            'file' => 'bg-yellow-100 text-yellow-800',
            'system' => 'bg-gray-100 text-gray-800'
        ];

        return $badges[$this->message_type] ?? 'bg-gray-100 text-gray-800';
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
