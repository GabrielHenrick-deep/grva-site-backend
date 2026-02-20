<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MemberProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminCsvImportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', fn (Request $r) => $r->user());

// Públicos
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{slug}', [BlogController::class, 'show']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/members', [MemberController::class, 'index']);
Route::get('/members/names', [MemberController::class, 'indexNames']);
Route::get('/members/{member}', [MemberController::class, 'show']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::get('/publications', [PublicationController::class, 'index']);
Route::get('/publications/{publication}', [PublicationController::class, 'show']);
Route::post('/contact', [ContactController::class, 'send']);


Route::apiResource('members', MemberController::class);
// Mova estas linhas para DENTRO do grupo auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class)->except(['index', 'show']);
    Route::apiResource('publications', PublicationController::class)->except(['index', 'show']);
    
    Route::post('/import-members', [AdminCsvImportController::class, 'import']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

