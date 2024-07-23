<?php

namespace App\Http\Routes;

use App\Http\Middleware\AuthorizeResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

class UsersRoute
{
    public static function web() : void
    {
        Route::middleware(['auth', 'verified', AuthorizeResource::class])
            ->group(function () {
                Route::resource('users', UserController::class)
                    ->except('show')
                    ->withTrashed();

                Route::put('users/{user}/restore', [UserController::class, 'restore'])
                    ->name('users.restore')
                    ->withTrashed();
            });
    }
}
