<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
    use HasFactory;

    protected $table = 'system_notifications';

    protected $fillable = [
        'user_id',
        'title_ar',
        'title_en',
        'message_ar',
        'message_en',
        'type',
        'data',
        'is_read',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getTitleAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getMessageAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->message_ar : $this->message_en;
    }

    public function getTypeIconAttribute()
    {
        $icons = [
            'info' => 'fas fa-info-circle text-blue-500',
            'success' => 'fas fa-check-circle text-green-500',
            'warning' => 'fas fa-exclamation-triangle text-yellow-500',
            'error' => 'fas fa-times-circle text-red-500',
        ];

        return $icons[$this->type] ?? $icons['info'];
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    // Helper Methods
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}