<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['controller' => UserController::class, 'prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/{user}', 'getUser')->name('get-user');
});
