<?php

use App\Infrastructure\Http\Controllers\AuthController;
use App\Infrastructure\Http\Controllers\ChildProfileController;
use App\Infrastructure\Http\Controllers\ProgressController;
use App\Infrastructure\Http\Controllers\QuizController;
use App\Infrastructure\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// ============================================================
// ROTAS PÚBLICAS — Autenticação
// ============================================================
Route::prefix('auth')->group(function () {
    Route::post('parent/register', [AuthController::class, 'registerParent']);
    Route::post('parent/login',    [AuthController::class, 'loginParent']);
    Route::post('child/login',     [AuthController::class, 'loginChild']);
    Route::post('logout',          [AuthController::class, 'logout'])->middleware('jwt.auth');
});

// ============================================================
// ROTAS DO PAI — requer token com role = parent
// ============================================================
Route::prefix('parent')->middleware(['jwt.parent'])->group(function () {
    Route::get('children',                      [ChildProfileController::class, 'index']);
    Route::post('children',                     [ChildProfileController::class, 'store']);
    Route::delete('children/{id}',              [ChildProfileController::class, 'destroy']);
    Route::get('children/{id}/progress',        [ProgressController::class, 'parentViewsChildProgress']);
});

// ============================================================
// ROTAS DA CRIANÇA — requer token com role = child
// ============================================================
Route::middleware(['jwt.child'])->group(function () {
    Route::get('quiz/{table_number}',  [QuizController::class, 'show']);
    Route::post('sessions',            [SessionController::class, 'store']);
    Route::get('child/progress',       [ProgressController::class, 'childProgress']);
});
