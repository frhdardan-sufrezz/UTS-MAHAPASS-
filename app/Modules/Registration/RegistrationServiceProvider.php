<?php

namespace App\Modules\Registration;

use App\Modules\Auth\Events\UserTerdaftar;
use App\Modules\Registration\Listeners\BuatPesertaSaatUserTerdaftar;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class RegistrationServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__.'/Views', 'registration');

        // Domain Event dari modul Auth
        Event::listen(UserTerdaftar::class, BuatPesertaSaatUserTerdaftar::class);
    }
}
