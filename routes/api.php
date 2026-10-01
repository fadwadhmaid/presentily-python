<?php
// routes/api.php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\MessageController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
// ─── Admin public (login) ──────────────────────
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// ─── Admin protégé ─────────────────────────────
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/me', [AdminAuthController::class, 'me']);

    // Dashboard
    Route::get('/stats', [AdminDashboardController::class, 'stats']);
    Route::get('/users', [AdminDashboardController::class, 'users']);

    // Messages
    Route::get('/messages', [AdminMessageController::class, 'index']);
    Route::get('/messages/{id}', [AdminMessageController::class, 'show']);
    Route::post('/messages/{id}/reply', [AdminMessageController::class, 'reply']);
    Route::patch('/messages/{id}/status', [AdminMessageController::class, 'updateStatus']);
    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy']);
});
// Route de test
Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne !']);
});

// Routes d'authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/check-email', [AuthController::class, 'checkEmail']);
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::post('/resend-verification', [AuthController::class, 'resendVerification']);

Route::get('/sections', [CourseController::class, 'sections']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/user/section', [CourseController::class, 'setSection']);
    Route::put('/user/avatar', [ProfileController::class, 'updateAvatar']);
  // Messages (avis / réclamations)
    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::get('/messages/{id}', [MessageController::class, 'show']);
    Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
     // ─── Cours ────────────────────────────────────
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);
    Route::put('/courses/{course}/progress', [CourseController::class, 'updateProgress']);
});