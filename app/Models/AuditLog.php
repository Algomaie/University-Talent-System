<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeForModel($query, $modelType, $modelId = null)
    {
        return $query->where('model_type', $modelType)
                    ->when($modelId, function ($q) use ($modelId) {
                        return $q->where('model_id', $modelId);
                    });
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    // Accessors
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    public function getActionDescriptionAttribute()
    {
        $actions = [
            'create' => 'Created',
            'update' => 'Updated',
            'delete' => 'Deleted',
        ];

        return $actions[$this->action] ?? ucfirst($this->action);
    }
}