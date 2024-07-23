<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            Gate::before(function ($user, $ability) {
                if ($user->id == 1) {
                    return true;
                }
                return false;
            });

            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                Gate::define($permission->name, function (User $user) use ($permission) {
                    return $user->role->permissions->contains('id', $permission->id);
                });
            }

        }
    }
}
