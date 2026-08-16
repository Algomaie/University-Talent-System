<?php

namespace App\Policies;

use App\Models\Competition;
use App\Models\User;

class CompetitionPolicy
{
    /**
     * Anyone authenticated can view competitions.
     */
    public function view(User $user, Competition $competition): bool
    {
        return true;
    }

    /**
     * Admins and managers can create competitions.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    /**
     * Admins can update any competition.
     * Managers can only update competitions they created or manage.
     */
    public function update(User $user, Competition $competition): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            return $competition->created_by === $user->id
                || $competition->managers()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Only admins can delete competitions.
     */
    public function delete(User $user, Competition $competition): bool
    {
        return $user->isAdmin();
    }

    /**
     * Managers who own/manage the competition can manage its submissions.
     */
    public function manage(User $user, Competition $competition): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            return $competition->created_by === $user->id
                || $competition->managers()->where('user_id', $user->id)->exists();
        }

        return false;
    }
}
