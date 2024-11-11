<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // ResetPassword::createUrlUsing(function (User $user, string $token) {
        //     return 'http://127.0.0.1:8000/password.reset?token='.$token;
        // });

    ResetPasswordNotification::createUrlUsing(function ($notifiable, $token) {
        return route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()]);
    });

    }
}
