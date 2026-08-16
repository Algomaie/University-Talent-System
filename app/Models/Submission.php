<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use App\Notifications\SubmissionStatusChanged;

class Submission extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'competition_id',
        'talent_id',
        'title',
        'description',
        'files',
        'status',
        'rejection_reason',
        'submitted_at',
    ];

    protected $casts = [
        'files' => 'array',
        'submitted_at' => 'datetime',
    ];

    // Store the original status for comparison
    protected $originalStatus;

    protected static function booted()
    {
        static::retrieved(function ($model) {
            $model->originalStatus = $model->status;
        });

        static::updated(function ($model) {
            // Check if status has changed
            if ($model->originalStatus && $model->originalStatus !== $model->status) {
                // Send notification to the student
                $model->user->notify(new SubmissionStatusChanged($model, $model->originalStatus));
            }
            
            // Update the original status
            $model->originalStatus = $model->status;
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => __('Pending')],
            'under_review' => ['class' => 'bg-blue-100 text-blue-800', 'text' => __('Under Review')],
            'nominated' => ['class' => 'bg-purple-100 text-purple-800', 'text' => __('Nominated')],
            'approved' => ['class' => 'bg-green-100 text-green-800', 'text' => __('Approved')],
            'rejected' => ['class' => 'bg-red-100 text-red-800', 'text' => __('Rejected')],
        ];

        return $badges[$this->status] ?? $badges['pending'];
    }

    public function getFilesUrlAttribute()
    {
        if (!$this->files) return [];
        
        return collect($this->files)->map(function ($file) {
            return [
                'name' => basename($file),
                'url' => asset('storage/' . $file),
                'type' => pathinfo($file, PATHINFO_EXTENSION),
            ];
        });
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeNominated($query)
    {
        return $query->where('status', 'nominated');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Helper Methods
    public function canBeEvaluated()
    {
        return in_array($this->status, ['pending', 'under_review']);
    }

    public function isEvaluatedBy($userId)
    {
        return $this->evaluations()->where('evaluator_id', $userId)->exists();
    }

    public function getAverageScore()
    {
        return $this->evaluations()->avg('overall_score');
    }
}