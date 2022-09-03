<?php

use App\Http\Controllers\Api\ForumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::name('api.')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('/forum')->name('forum.')->group(function () {
        Route::get('/', [ForumController::class, 'index'])->name('all');
        Route::post('/create', [ForumController::class, 'create'])->name('create');
        Route::prefix('/{forum}')->group(function () {
            Route::post('/update', [ForumController::class, 'update'])->name('update');
        });
    });
});
