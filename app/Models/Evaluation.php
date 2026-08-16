<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use App\Notifications\StudentSubmissionEvaluated;

class Evaluation extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'submission_id',
        'evaluator_id',
        'creativity_score',
        'technical_score',
        'presentation_score',
        'overall_score',
        'comments',
        'is_nominated',
        'nomination_reason',
    ];

    protected $casts = [
        'is_nominated' => 'boolean',
        'creativity_score' => 'integer',
        'technical_score' => 'integer',
        'presentation_score' => 'integer',
        'overall_score' => 'integer',
    ];

    protected static function booted()
    {
        static::created(function ($evaluation) {
            // Send notification to the student when evaluation is completed
            $evaluation->submission->user->notify(new StudentSubmissionEvaluated($evaluation));
        });
    }

    // Relationships
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    // Mutators
    public function setOverallScoreAttribute($value)
    {
        // Only set the value if it's provided and not null
        if ($value !== null && $value !== '') {
            $this->attributes['overall_score'] = (int) $value;
        } elseif (!isset($this->attributes['overall_score'])) {
            // Ensure there's always a value for overall_score
            $this->attributes['overall_score'] = 0;
        }
    }

    // Scopes
    public function scopeNominated($query)
    {
        return $query->where('is_nominated', true);
    }

    // Helper Methods
    public function getScorePercentage()
    {
        return $this->overall_score ? ($this->overall_score / 10) * 100 : 0;
    }

    public function getScoreGrade()
    {
        $score = $this->overall_score;
        
        if ($score >= 9) return 'A+';
        if ($score >= 8) return 'A';
        if ($score >= 7) return 'B+';
        if ($score >= 6) return 'B';
        if ($score >= 5) return 'C';
        
        return 'F';
    }
}