<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;

class SubmissionPolicy
{
    /**
     * Students can view their own submissions.
     * Managers can view submissions in competitions they manage.
     * Admins can view all submissions.
     */
    public function view(User $user, Submission $submission): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isStudent()) {
            return $submission->user_id === $user->id;
        }

        if ($user->isManager()) {
            $competition = $submission->competition;
            return $competition->created_by === $user->id
                || $competition->managers()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Only the owning student can update their submission (if status allows).
     */
    public function update(User $user, Submission $submission): bool
    {
        if (!$user->isStudent()) {
            return false;
        }

        return $submission->user_id === $user->id
            && in_array($submission->status, ['pending', 'under_review']);
    }

    /**
     * Only the owning student can delete their submission (if status allows).
     */
    public function delete(User $user, Submission $submission): bool
    {
        if (!$user->isStudent()) {
            return false;
        }

        return $submission->user_id === $user->id
            && in_array($submission->status, ['pending', 'rejected']);
    }

    /**
     * Managers can evaluate submissions in competitions they manage.
     */
    public function evaluate(User $user, Submission $submission): bool
    {
        if (!$user->isManager()) {
            return false;
        }

        $competition = $submission->competition;
        return $competition->created_by === $user->id
            || $competition->managers()->where('user_id', $user->id)->exists();
    }
}
