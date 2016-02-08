<?php

namespace Administr\Assets;

use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Manager::class, function(){
            return new Manager($this->app['session']);
        });

        $this->app->alias(Manager::class, 'administr.assets');
    }
}