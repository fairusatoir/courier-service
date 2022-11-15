<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Log::setTimezone(new \DateTimeZone('Asia/Jakarta'));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** To block access log */
        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->role, [
                    'admin',
                ]);
        });
    }
}
