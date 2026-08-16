<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\Auditable;

class Competition extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'start_date',
        'end_date',
        'registration_deadline',
        'max_participants',
        'allowed_talents',
        'status',
        'created_by',
        'evaluation_criteria',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_deadline' => 'date',
        'allowed_talents' => 'array',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function allowedTalentsList()
    {
        // Handle different data types for allowed_talents
        $allowedTalents = $this->allowed_talents;
        
        // If it's a JSON string, decode it
        if (is_string($allowedTalents)) {
            $allowedTalents = json_decode($allowedTalents, true);
        }
        
        // Ensure we have an array and handle null/empty cases
        if (!is_array($allowedTalents)) {
            $allowedTalents = [];
        }
        
        // Filter out any null values and convert string IDs to integers
        $allowedTalents = array_filter($allowedTalents, function($value) {
            return !is_null($value) && $value !== '';
        });
        
        // Convert string IDs to integers if needed
        $allowedTalents = array_map(function($value) {
            return is_string($value) ? (int)$value : $value;
        }, $allowedTalents);
        
        return Talent::whereIn('id', $allowedTalents)->get();
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'competition_managers')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // Accessors
    public function getTitleAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => ['class' => 'bg-gray-100 text-gray-800', 'text' => __('Draft')],
            'active' => ['class' => 'bg-green-100 text-green-800', 'text' => __('Active')],
            'closed' => ['class' => 'bg-red-100 text-red-800', 'text' => __('Closed')],
            'cancelled' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => __('Cancelled')],
        ];

        return $badges[$this->status] ?? $badges['draft'];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'active')
                    ->where('registration_deadline', '>=', Carbon::now());
    }

    // Helper Methods
    public function isOpen()
    {
        return $this->status === 'active' && 
               Carbon::now()->lte($this->registration_deadline);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function canAcceptSubmissions()
    {
        return $this->isOpen() && 
               (!$this->max_participants || 
                $this->submissions()->count() < $this->max_participants);
    }
}