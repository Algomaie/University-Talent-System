<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\Auditable;
use App\Models\SystemNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Auditable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
        'department',
        'academic_level',
        'phone',
        'avatar',
        'is_active',
        'major',
        'year_of_study',
        'interests',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluator_id');
    }

    public function competitions()
    {
        return $this->hasMany(Competition::class, 'created_by');
    }

    public function managedCompetitions()
    {
        return $this->belongsToMany(Competition::class, 'competition_managers')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(SystemNotification::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'generated_by');
    }

    // Accessors & Mutators
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-avatar.png');
    }

    // Scopes
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeManagers($query)
    {
        return $query->where('role', 'manager');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper Methods
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasSubmissionInCompetition($competitionId)
    {
        return $this->submissions()->where('competition_id', $competitionId)->exists();
    }

    /**
     * Override the notify method to use our custom SystemNotification model
     */
    public function notify($instance)
    {
        // Check if the notification has a toDatabase method
        if (method_exists($instance, 'toDatabase')) {
            // Use our custom notification system
            $instance->toDatabase($this);
        } else {
            // Fall back to the default notification system
            parent::notify($instance);
        }
    }
}