<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\PlayerRepository;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\TournamentRepository;
use App\Repositories\Contracts\TournamentRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
        $this->app->bind(TournamentRepositoryInterface::class, TournamentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
