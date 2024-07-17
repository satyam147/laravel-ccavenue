<?php

namespace Satyam147\LaravelCcavenue;

use Illuminate\Support\ServiceProvider;

class CcAvenueServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/ccavenue.php',
            'ccavenue'
        );
        $this->publishes([
            __DIR__ . '/config/ccavenue.php' => \config_path('ccavenue.php')
        ]);
    }

    public function register()
    {
    }
}
