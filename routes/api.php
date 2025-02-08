<?php

use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'V1',
    'middleware' => 'auth:sanctum'
],
function(){
    Route::apiResource('/users', UserController::class);

    Route::post('/blogs/{blog}', [BlogController::class, 'update'])->middleware('auth')->name('blogs.update');
    Route::post('/blogs/delete-attachment/{blog}', [BlogController::class, 'destroy_attachment'])->middleware('auth')->name('delete.attachment');
    Route::apiResource('/blogs', BlogController::class)->middleware('auth');

    Route::apiResource('blogs.comments', CommentController::class)->middleware('auth');

    Route::get('/user', [AuthenticatedSessionController::class, 'show'])->name('auth.user');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
