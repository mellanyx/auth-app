<?php

use App\Http\Controllers\Api\User\ActionsController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\ProfileEditController;
use App\Http\Controllers\Api\User\RegisterController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api'], function () {
    Route::post('/user/auth', [AuthController::class, 'auth']);

    Route::post('/user/register', [RegisterController::class, 'register']);

    // Проверка авторизации
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/checkAuth', [AuthController::class, 'getCurrentAuth']);
    });

    Route::post('/user/profile/edit', [ProfileEditController::class, 'edit']);

    Route::get('/users', [ActionsController::class, 'getUsers']);
});

Route::get('/user/logout', [AuthController::class, 'logout']);

Route::get('/{any}', function() {
    return view('spa');
})->where('any', '.*')->name('spa');
