<?php

namespace App\Providers;

use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Services\Api\CategoryService;
use App\Services\Api\DepartmentService;
use App\Services\Api\UserService;
use App\Contracts\Services\Api\CommentServiceInterface;
use App\Services\Api\CommentService;
use App\Contracts\Services\Api\CommentHistoryServiceInterface;
use App\Services\Api\CommentHistoryService;
use App\Contracts\Services\Api\RequestServiceInterface;
use App\Services\Api\RequestService;
use App\Contracts\Services\Api\RequestHistoryServiceInterface;
use App\Services\Api\RequestHistoryService;
use App\Contracts\Services\Api\HistoryServiceInterface;
use App\Services\Api\HistoryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $services = [
            [
                UserServiceInterface::class,
                UserService::class
            ],
            [
                CommentServiceInterface::class,
                CommentService::class
            ],
            [
                CommentHistoryServiceInterface::class,
                CommentHistoryService::class
            ],
            [
                RequestServiceInterface::class,
                RequestService::class
            ],
            [
                CategoryServiceInterface::class,
                CategoryService::class
            ],
            [
                DepartmentServiceInterface::class,
                DepartmentService::class
            ],
            [
                RequestHistoryServiceInterface::class,
                RequestHistoryService::class
            ],
            [
                HistoryServiceInterface::class,
                HistoryService::class
            ],
        ];
        foreach ($services as $service) {
            $this->app->bind(
                $service[0],
                $service[1]
            );
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
