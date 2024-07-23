<?php

namespace App\Http\Routes;

use App\Http\Middleware\AuthorizeResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

class RolesRoute
{
    public static function web() : void
    {
        Route::middleware(['auth', 'verified', AuthorizeResource::class])
            ->group(function () {
                Route::resource('roles', RoleController::class)
                    ->except('show')
                    ->parameters([
                        'roles' => 'role:slug',
                    ])->withTrashed();

                Route::put('roles/{role:slug}/restore', [RoleController::class, 'restore'])
                    ->name('roles.restore')->withTrashed();
            });
    }
}
