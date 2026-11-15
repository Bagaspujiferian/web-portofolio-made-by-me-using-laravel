<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Public Portfolio Routes
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/project/{slug}', [PortfolioController::class, 'showProject'])->name('portfolio.project.show');

// Health & Ping JSON Endpoint
Route::get('/ping', function () {
    return response()->json([
        'status' => 'Bagas.Dev is Alive!',
        'laravel_version' => app()->version(),
        'php_version' => PHP_VERSION,
        'server_time' => now()->timezone('Asia/Jakarta')->toIso8601String(),
    ]);
})->name('portfolio.ping');

Route::get('/health', function () {
    return response()->json([
        'status' => 'Bagas.Dev is Alive!',
        'laravel_version' => app()->version(),
        'php_version' => PHP_VERSION,
        'server_time' => now()->timezone('Asia/Jakarta')->toIso8601String(),
    ]);
})->name('portfolio.health');

Route::post('/contact', [PortfolioController::class, 'storeContact'])
    ->middleware('throttle:10,1')
    ->name('portfolio.contact.store');

Route::post('/comment', [PortfolioController::class, 'storeComment'])
    ->middleware('throttle:15,1')
    ->name('portfolio.comment.store');

// Admin CMS Routes (Tabler UI)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Educations
    Route::post('/educations', [AdminController::class, 'storeEducation'])->name('educations.store');
    Route::delete('/educations/{id}', [AdminController::class, 'destroyEducation'])->name('educations.destroy');

    // Experiences (with SoftDeletes Trash/Restore/ForceDelete)
    Route::post('/experiences', [AdminController::class, 'storeExperience'])->name('experiences.store');
    Route::delete('/experiences/{id}', [AdminController::class, 'destroyExperience'])->name('experiences.destroy');
    Route::post('/experiences/{id}/restore', [AdminController::class, 'restoreExperience'])->name('experiences.restore');
    Route::delete('/experiences/{id}/force', [AdminController::class, 'forceDeleteExperience'])->name('experiences.force-delete');

    // Projects (with SoftDeletes Trash/Restore/ForceDelete)
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::put('/projects/{id}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{id}', [AdminController::class, 'destroyProject'])->name('projects.destroy');
    Route::post('/projects/{id}/restore', [AdminController::class, 'restoreProject'])->name('projects.restore');
    Route::delete('/projects/{id}/force', [AdminController::class, 'forceDeleteProject'])->name('projects.force-delete');

    // Certificates & Achievements (with SoftDeletes Trash/Restore/ForceDelete)
    Route::post('/certificates', [AdminController::class, 'storeCertificate'])->name('certificates.store');
    Route::delete('/certificates/{id}', [AdminController::class, 'destroyCertificate'])->name('certificates.destroy');
    Route::post('/certificates/{id}/restore', [AdminController::class, 'restoreCertificate'])->name('certificates.restore');
    Route::delete('/certificates/{id}/force', [AdminController::class, 'forceDeleteCertificate'])->name('certificates.force-delete');

    // Skills (Tech Stack)
    Route::post('/skills', [AdminController::class, 'storeSkill'])->name('skills.store');
    Route::delete('/skills/{id}', [AdminController::class, 'destroySkill'])->name('skills.destroy');

    // Contact Messages (with SoftDeletes Trash/Restore/ForceDelete)
    Route::patch('/messages/{id}/toggle-read', [AdminController::class, 'toggleMessageRead'])->name('messages.toggle-read');
    Route::delete('/messages/{id}', [AdminController::class, 'destroyMessage'])->name('messages.destroy');
    Route::post('/messages/{id}/restore', [AdminController::class, 'restoreMessage'])->name('messages.restore');
    Route::delete('/messages/{id}/force', [AdminController::class, 'forceDeleteMessage'])->name('messages.force-delete');

    // Public Guestbook Comments (with SoftDeletes Trash/Restore/ForceDelete)
    Route::patch('/comments/{id}/toggle-approval', [AdminController::class, 'toggleCommentApproval'])->name('comments.toggle-approval');
    Route::delete('/comments/{id}', [AdminController::class, 'destroyComment'])->name('comments.destroy');
    Route::post('/comments/{id}/restore', [AdminController::class, 'restoreComment'])->name('comments.restore');
    Route::delete('/comments/{id}/force', [AdminController::class, 'forceDeleteComment'])->name('comments.force-delete');
});
