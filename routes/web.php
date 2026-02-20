<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('members', MemberController::class)->except(['index', 'show']);


// Route::get('/login', function () {
//     return 'Página de login (apenas placeholder ou redirecionamento frontend)';
// })->name('login');

// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
// Route::post('/contact', [ContactController::class, 'send']);

