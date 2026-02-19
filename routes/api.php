<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Project;
use App\Models\Member;
use App\Models\Publication;
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


// Route::post('/contact', [ContactController::class, 'send']);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{slug}', [BlogController::class, 'show']);

Route::get('/events', [EventController::class, 'index']);
Route::post('/contact', [ContactController::class, 'send']);

Route::apiResource('projects', ProjectController::class)->only(['index', 'show']);
Route::apiResource('publications', PublicationController::class)->only(['index', 'show']);

Route::apiResource('members', MemberController::class)->only(['index', 'show']);
Route::get('/members/{member}', [MemberController::class, 'show']);

Route::post('/import-members', [AdminCsvImportController::class, 'import']);
Route::apiResource('members', MemberController::class)->except(['index', 'show']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class)->except(['index', 'show']);
    Route::apiResource('publications', PublicationController::class)->except(['index', 'show']);
    
});
