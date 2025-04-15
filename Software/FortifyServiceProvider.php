<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Actions\Auth\RegisterResponse as CustomRegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the custom registration redirect class
        $this->app->singleton(RegisterResponse::class, CustomRegisterResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Show the custom registration form view
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // Handle registration with our custom user creation logic
        Fortify::createUsersUsing(CreateNewUser::class);
    }
}
