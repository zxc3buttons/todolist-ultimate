<?php

namespace App\Providers;

use App\Http\Services\interfaces\TaskService;
use App\Http\Services\interfaces\UserService;
use App\Http\Services\TaskServiceImpl;
use App\Http\Services\UserServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskService::class, TaskServiceImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
