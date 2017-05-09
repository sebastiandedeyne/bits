<?php

namespace Bits\Bits\Laravel;

use Bits\Bits\Bit;
use Bits\Bits\Bits;
use Bits\Bits\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
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
        $this->mergeConfigFrom(__DIR__.'/../../config/bits.php', 'bits');

        $this->app->singleton(Repository::class, function () {
            return new CacheRepository(
                $this->app->make(EloquentRepository::class),
                Cache::driver(Config::get('bits.cache_driver'))
            );
        });

        $this->app->singleton(Bits::class, function () {
            return new Bits(
                $this->app->make(Repository::class),
                Config::get('bits.types')
            );
        });

        $this->app->alias(Bits::class, 'bits');
    }

    /**
     * Publish settings for the configuration file.
     */
    protected function publishesConfig()
    {
        $source = __DIR__.'/../../config/bits.php';
        $target = config_path('bits.php');

        $this->publishes([$source => $target], 'config');
    }

    /**
     * Publish settings for the migrations.
     */
    protected function publishesMigrations()
    {
        $source = __DIR__.'/../../database/migrations/create_bits_table.php.stub';
        $target = database_path('migrations/'.date('Y_m_d_His', time()).'_create_bits_table.php');
        
        $this->publishes([$source => $target], 'migrations');
    }
}
