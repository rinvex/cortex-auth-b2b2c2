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
        require __DIR__.'/../../routes/breadcrumbs/adminarea.php';
        require __DIR__.'/../../routes/breadcrumbs/frontarea.php';
        require __DIR__.'/../../routes/breadcrumbs/tenantarea.php';
        require __DIR__.'/../../routes/breadcrumbs/managerarea.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/adminarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/frontarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/tenantarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/managerarea.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/auth');
        $this->app->runningInConsole() || $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus/managerarea.php';
            require __DIR__.'/../../routes/menus/adminarea.php';
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
