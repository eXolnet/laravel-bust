<?php

namespace Exolnet\Bust;

use Illuminate\Support\ServiceProvider;

class BustServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/bust.php' => config_path('bust.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bust.php', 'bust');

        $this->app->singleton('bust', function () {
            return $this->app->make(Bust::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bust'];
    }
}
