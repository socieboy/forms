<?php

namespace Socieboy\Forms;

use Collective\Html\HtmlServiceProvider;
use Illuminate\Support\ServiceProvider;

class FormsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishFiles();

        $this->loadViewsFrom(__DIR__.'/views', 'FieldBuilder');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(HtmlServiceProvider::class);

        $this->app['field'] = $this->app->share(function($app)
        {
            $fieldBuilder = new FieldBuilder($app['form'], $app['view'], $app['session.store']);
            return $fieldBuilder;
        });

        include __DIR__ . '/helpers.php';
    }


    /**
     * Publish config file for
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__.'/config/field-builder.php' => base_path('config/field-builder.php'),
        ]);

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/socieboy/forms/'),
        ], 'form-builder-views');
    }
}
