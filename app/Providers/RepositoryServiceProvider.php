<?php

namespace App\Providers;

use App\Contracts\AuthRepositoryInterface;
use App\Contracts\FileRepositoryInterface;
use App\Contracts\TaskRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\File\FileRepository;
use App\Repositories\Task\TaskRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register repositories and contracts in their service container.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            AuthRepositoryInterface::class,
            AuthRepository::class
        );

        $this->app->bind(
            TaskRepositoryInterface::class,
            TaskRepository::class
        );

        $this->app->bind(
            FileRepositoryInterface::class,
            FileRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
