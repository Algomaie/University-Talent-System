<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\Submission;
use App\Models\User;

class EvaluationPolicy
{
    /**
     * Only managers can create evaluations.
     */
    public function create(User $user, Submission $submission): bool
    {
        if (!$user->isManager()) {
            return false;
        }

        $competition = $submission->competition;
        return $competition->created_by === $user->id
            || $competition->managers()->where('user_id', $user->id)->exists();
    }

    /**
     * Only the evaluator who created the evaluation can update it.
     */
    public function update(User $user, Evaluation $evaluation): bool
    {
        return $user->isManager() && $evaluation->evaluator_id === $user->id;
    }

    /**
     * Students can view evaluations of their own submissions.
     * Managers and admins can view any evaluation.
     */
    public function view(User $user, Evaluation $evaluation): bool
    {
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }

        return $evaluation->submission->user_id === $user->id;
    }
}
