<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ApiProviderInterface;
use App\Repositories\BusinessTaskRepository;
use App\Repositories\JobTaskRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiProviderInterface::class, function($app) {
            return [
                $this->app->make(BusinessTaskRepository::class),
                $this->app->make(JobTaskRepository::class),
            ];
        });
    }
}
