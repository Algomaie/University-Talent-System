<?php

namespace App\Providers;

use App\Models\Competition;
use App\Models\Evaluation;
use App\Models\Submission;
use App\Policies\CompetitionPolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\SubmissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Submission::class => SubmissionPolicy::class,
        Competition::class => CompetitionPolicy::class,
        Evaluation::class => EvaluationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Admin gate — convenience for admin-only features
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });
    }
}
