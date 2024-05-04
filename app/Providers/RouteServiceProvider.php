<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    private array $apiRoutes = [
        "v1" => [
            "user" => ["middleware" => "api", "prefix" => "users"],
            "auth" => ["middleware" => "api", "prefix" => "auth"],
        ]
    ];
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->bootApiRoutes();
    }

    private function bootApiRoutes(): void
    {
        foreach ($this->apiRoutes as $apiVersion => $apiRoutes) {
            foreach ($apiRoutes as $apiFileName => $apiRoute) {
                Route::middleware($apiRoute["middleware"])
                    ->prefix(sprintf("api/%s/%s", $apiVersion, $apiRoute["prefix"]))
                    ->group(base_path(sprintf("routes/api/%s/%s.php", $apiVersion, $apiFileName)));
            }
        }
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login-register-limiter', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('login-confirm-limiter', function (Request $request) {
            return Limit::perMinute(5)->by(url()->current() . $request->ip());
        });

        RateLimiter::for('login-resend-otp-limiter', function (Request $request) {
            return Limit::perMinute(5)->by(url()->current() . $request->ip());
        });

    }
}
