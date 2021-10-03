<?php

namespace App\Providers;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\UserRepository;
use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Contracts\Repositories\CommentHistoryRepositoryInterface;
use App\Repositories\CommentHistoryRepository;
use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Repositories\RequestRepository;
use App\Contracts\Repositories\RequestHistoryRepositoryInterface;
use App\Repositories\RequestHistoryRepository;
use App\Contracts\Repositories\HistoryRepositoryInterface;
use App\Repositories\HistoryRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected static $repositories = [
        'user' => [
            UserRepositoryInterface::class,
            UserRepository::class,
        ],
        'comment' => [
            CommentRepositoryInterface::class,
            CommentRepository::class,
        ],
        'comment_history' => [
            CommentHistoryRepositoryInterface::class,
            CommentHistoryRepository::class,
        ],
        'request' => [
            RequestRepositoryInterface::class,
            RequestRepository::class,
        ],
        'category' => [
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        ],
        'department' => [
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        ],
        'request_history' => [
            RequestHistoryRepositoryInterface::class,
            RequestHistoryRepository::class,
        ],
        'history' => [
            HistoryRepositoryInterface::class,
            HistoryRepository::class,
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (static::$repositories as $repository) {
            $this->app->singleton(
                $repository[0],
                $repository[1]
            );
        }
    }
}
