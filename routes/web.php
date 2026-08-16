<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\SubmissionController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\EvaluationController;
use App\Http\Controllers\Manager\CompetitionController as ManagerCompetitionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\TalentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BackupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/language/{locale}', [HomeController::class, 'switchLanguage'])->name('language.switch');


// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth Routes (handled by Laravel Breeze)
require __DIR__.'/auth.php';

// Student Routes
Route::middleware(['auth', 'check.role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [SubmissionController::class, 'index'])->name('index');
        Route::get('/create/{competition?}', [SubmissionController::class, 'create'])->name('create');
        Route::post('/', [SubmissionController::class, 'store'])->name('store');
        Route::get('/{submission}', [SubmissionController::class, 'show'])->name('show');
        Route::get('/{submission}/edit', [SubmissionController::class, 'edit'])->name('edit');
        Route::put('/{submission}', [SubmissionController::class, 'update'])->name('update');
        Route::delete('/{submission}', [SubmissionController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [StudentDashboardController::class, 'notifications'])->name('index');
        Route::post('/{notification}/read', [StudentDashboardController::class, 'markNotificationAsRead'])->name('read');
        Route::match(['get', 'post'], '/read-all', [StudentDashboardController::class, 'markAllNotificationsAsRead'])->name('read-all');
    });
});

// Manager Routes
Route::middleware(['auth', 'check.role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');
    
    // Competition Management
    Route::prefix('competitions')->name('competitions.')->group(function () {
        Route::get('/', [ManagerCompetitionController::class, 'index'])->name('index');
        Route::get('/create', [ManagerCompetitionController::class, 'create'])->name('create');
        Route::post('/', [ManagerCompetitionController::class, 'store'])->name('store');
        Route::get('/{competition}', [ManagerCompetitionController::class, 'show'])->name('show');
        Route::get('/{competition}/edit', [ManagerCompetitionController::class, 'edit'])->name('edit');
        Route::put('/{competition}', [ManagerCompetitionController::class, 'update'])->name('update');
        Route::post('/{competition}/archive', [ManagerCompetitionController::class, 'archive'])->name('archive');
        Route::get('/{competition}/submissions', [ManagerCompetitionController::class, 'submissions'])->name('submissions');
        Route::get('/{competition}/rankings', [ManagerCompetitionController::class, 'rankings'])->name('rankings');
        Route::post('/{competition}/notifications', [ManagerCompetitionController::class, 'sendNotifications'])->name('notifications.send');
    });
    
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/', [EvaluationController::class, 'index'])->name('index');
        Route::get('/{submission}', [EvaluationController::class, 'show'])->name('show');
        Route::get('/{submission}/create', [EvaluationController::class, 'create'])->name('create');
        Route::post('/{submission}', [EvaluationController::class, 'store'])->name('store');
        Route::get('/{submission}/edit', [EvaluationController::class, 'edit'])->name('edit');
        Route::put('/{submission}', [EvaluationController::class, 'update'])->name('update');
    });
});

// Admin Routes
Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Nominated Submissions
    Route::get('/nominated', [AdminDashboardController::class, 'nominatedSubmissions'])->name('nominated.index');
    Route::post('/nominated/{submission}/approve', [AdminDashboardController::class, 'approveNomination'])->name('nominated.approve');
    Route::post('/nominated/{submission}/reject', [AdminDashboardController::class, 'rejectNomination'])->name('nominated.reject');
    
    // User Management
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Competition Management
    Route::resource('competitions', CompetitionController::class);
    Route::get('/competitions/create/new', [CompetitionController::class, 'createNew'])->name('competitions.create.new');
    Route::patch('/competitions/{competition}/toggle-status', [CompetitionController::class, 'toggleStatus'])->name('competitions.toggle-status');
    
    // Talent Management
    Route::resource('talents', TalentController::class);
    Route::patch('/talents/{talent}/toggle-status', [TalentController::class, 'toggleStatus'])->name('talents.toggle-status');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/submissions', [ReportController::class, 'submissions'])->name('submissions');
        Route::get('/submissions/view', function () {
            return view('admin.reports.submissions');
        })->name('submissions.view');
        Route::get('/evaluations', [ReportController::class, 'evaluations'])->name('evaluations');
        Route::get('/evaluations/view', function () {
            return view('admin.reports.evaluations');
        })->name('evaluations.view');
        Route::get('/participants', [ReportController::class, 'participants'])->name('participants');
        Route::get('/participants/view', function () {
            return view('admin.reports.participants');
        })->name('participants.view');
        Route::get('/talents', [ReportController::class, 'talents'])->name('talents');
        Route::get('/talents/view', function () {
            return view('admin.reports.talents');
        })->name('talents.view');
        Route::post('/generate', [ReportController::class, 'generate'])->name('generate');
        Route::get('/download/{report}', [ReportController::class, 'download'])->name('download');
    });
    
    // Audit Logs
    Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);
    
    // Database Backups
    Route::resource('backups', BackupController::class)->only(['index', 'store', 'destroy']);
    Route::get('/backups/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::post('/backups/{filename}/restore', [BackupController::class, 'restore'])->name('backups.restore');
});