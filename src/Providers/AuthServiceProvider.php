<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/http.adminarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/http.frontarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/http.tenantarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/http.managerarea.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/auth');
        $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus.php';
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources(): void
    {
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/auth')], 'cortex-auth-views');
    }
}
