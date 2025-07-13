<?php

use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::post('/register', RegisterController::class)->name('register');
    // Route::post('/register', function () {
    //     dd('here');
    // });
});
