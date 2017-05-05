<?php

namespace Bits\Bits;

use Bits\Bits\Bit;
use Illuminate\Support\ServiceProvider;

class BitsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishesConfig();
            $this->publishesMigrations();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bits.php', 'bits');

        $this->app->alias(config('bits.model'), 'bits');
    }

    /**
     * Publish settings for the configuration file.
     */
    protected function publishesConfig()
    {
        $source = __DIR__.'/../config/bits.php';
        $target = config_path('bits.php');

        $this->publishes([$source => $target], 'config');
    }

    /**
     * Publish settings for the migrations.
     */
    protected function publishesMigrations()
    {
        $source = __DIR__.'/../database/migrations/create_bits_table.php.stub';
        $target = database_path('migrations/'.date('Y_m_d_His', time()).'_create_bits_table.php');
        
        $this->publishes([$source => $target], 'migrations');
    }
}
