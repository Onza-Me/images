<?php

namespace OnzaMe\Images;

use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;

class ImagesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'domda_backend_laravel_package_template');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'domda_backend_laravel_package_template');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('onzame_images.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/domda_backend_laravel_package_template'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/domda_backend_laravel_package_template'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/domda_backend_laravel_package_template'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'onzame_images');

        // Register the main class to use with the facade
        $this->app->singleton('onzame_images', function () {
            return new Images();
        });

        $this->app->singleton('image', function () {
            return new Images();
        });

        $this->app->register(
            ImageServiceProvider::class
        );

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Image', Image::class);
    }
}
