<?php

namespace App\Modules\Auth;

use App\Modules\Auth\Http\Middleware\CheckRole;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadViewsFrom(__DIR__.'/Views', 'auth');

        // alias middleware RBAC: ->middleware('role:admin') / 'role:peserta,admin'
        $this->app['router']->aliasMiddleware('role', CheckRole::class);
    }
}
