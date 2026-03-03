<?php

namespace App\Providers;

use App\Domain\Ports\Repositories\ChildProfileRepositoryInterface;
use App\Domain\Ports\Repositories\ParentProfileRepositoryInterface;
use App\Domain\Ports\Repositories\SessionRepositoryInterface;
use App\Infrastructure\Repositories\EloquentChildProfileRepository;
use App\Infrastructure\Repositories\EloquentParentProfileRepository;
use App\Infrastructure\Repositories\EloquentSessionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Binding: Interface do Domain → Implementação Concreta da Infraestrutura
        $this->app->bind(
            ParentProfileRepositoryInterface::class,
            EloquentParentProfileRepository::class
        );

        $this->app->bind(
            ChildProfileRepositoryInterface::class,
            EloquentChildProfileRepository::class
        );

        $this->app->bind(
            SessionRepositoryInterface::class,
            EloquentSessionRepository::class
        );
    }

    public function boot(): void {}
}
