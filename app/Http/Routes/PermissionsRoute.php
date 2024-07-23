<?php

namespace App\Http\Routes;

use App\Http\Middleware\AuthorizeResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;

class PermissionsRoute
{
    public static function web() : void
    {
        Route::middleware(['auth', 'verified', AuthorizeResource::class])
            ->group(function () {
                Route::resource('permissions', PermissionController::class)
                    ->except('show')
                    ->withTrashed();

                Route::put('permissions/{permission}/restore', [PermissionController::class, 'restore'])
                    ->name('permissions.restore')
                    ->withTrashed();
            });
    }
}
